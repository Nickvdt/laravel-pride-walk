<x-filament::page>
    <div id="calendar" class="h-[700px] rounded-lg shadow"></div>

    {{-- JSON met bestaande events uit de database --}}
    <script id="event-data" type="application/json">
        {!! $record->schedules->map(function ($s) use ($record) {
            return [
                'id' => $s->id,
                'title' => $record->title,
                'start' => \Carbon\Carbon::parse(
                    $s->date->format('Y-m-d') . ' ' . (is_array($s->start_time) ? $s->start_time['time'] : $s->start_time)
                )->toIso8601String(),
                'end' => \Carbon\Carbon::parse(
                    $s->date->format('Y-m-d') . ' ' . (is_array($s->end_time) ? $s->end_time['time'] : $s->end_time)
                )->toIso8601String(),
                'is_special_event' => $s->is_special_event,
                'special_event_description' => $s->special_event_description,
                'allDay' => false,
            ];
        })->values()->toJson() !!}
    </script>

    {{-- Modal --}}
    <div id="eventModal" class="hidden fixed inset-0 z-50 bg-black bg-opacity-30 flex items-center justify-center">
        <div class="bg-white dark:bg-gray-900 rounded shadow-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-bold mb-4 text-black dark:text-white">Add / Edit Event</h3>
            <form id="eventForm">
                <input type="hidden" name="event_id">

                <label class="block mb-2 text-black dark:text-white">
                    Start time:
                    <input type="time" name="start_time" class="w-full border rounded px-2 py-1 mt-1 bg-white text-black dark:bg-gray-800 dark:text-white" required>
                </label>

                <label class="block mb-2 text-black dark:text-white">
                    End time:
                    <input type="time" name="end_time" class="w-full border rounded px-2 py-1 mt-1 bg-white text-black dark:bg-gray-800 dark:text-white" required>
                </label>

                <label class="block mb-2 text-black dark:text-white">
                    Special Event:
                    <input type="checkbox" name="is_special_event" class="mr-2" onchange="toggleSpecialDescription()">
                </label>

                <div id="specialDescriptionContainer" class="hidden">
                    <label class="block mb-2 text-black dark:text-white">
                        Special Event Description:
                        <textarea name="special_event_description" class="w-full border rounded px-2 py-1 mt-1 bg-white text-black dark:bg-gray-800 dark:text-white" placeholder="Enter a description"></textarea>
                    </label>
                </div>


                <label class="block mb-2 text-black dark:text-white">
                    Repeat:
                    <select name="repeat_type" id="repeat_type" class="w-full border rounded px-2 py-1 mt-1 bg-white text-black dark:bg-gray-800 dark:text-white">
                        <option value="">Do not repeat</option>
                        <option value="daily">Daily</option>
                        <option value="weekly">Weekly on specific days</option>
                        <option value="weekdays">Every weekday (Mon–Fri)</option>
                    </select>
                </label>

                <div id="weekly-days" class="mb-2 hidden">
                    <label class="block text-black dark:text-white mb-1">Days of the week:</label>
                    <div class="flex flex-wrap gap-2">
                        @php
                        $days = ['MO' => 'Mon', 'TU' => 'Tue', 'WE' => 'Wed', 'TH' => 'Thu', 'FR' => 'Fri', 'SA' => 'Sat', 'SU' => 'Sun'];
                        @endphp
                        @foreach ($days as $key => $label)
                        <label class="flex items-center gap-1 text-sm text-black dark:text-white">
                            <input type="checkbox" name="repeat_days[]" value="{{ $key }}" class="accent-blue-600">
                            {{ $label }}
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="flex gap-2 mb-4">
                    <div class="w-1/2 hidden">
                        <label class="block text-black dark:text-white">
                            Start date:
                            <input type="date" name="repeat_start" class="w-full border rounded px-2 py-1 mt-1 bg-white text-black dark:bg-gray-800 dark:text-white">
                        </label>
                    </div>
                    <div class="w-1/2 hidden">
                        <label class="block text-black dark:text-white">
                            End date:
                            <input type="date" name="repeat_end" class="w-full border rounded px-2 py-1 mt-1 bg-white text-black dark:bg-gray-800 dark:text-white">
                        </label>
                    </div>
                </div>

                <div class="flex justify-between items-center gap-2 mt-4">
                    <button type="button" id="deleteEventBtn" class="px-4 py-2 bg-red-600 text-white rounded hidden">Delete</button>
                    <div class="flex gap-2 ml-auto">
                        <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-200 text-black rounded dark:bg-gray-700 dark:text-white">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- FullCalendar + recurrence helper --}}
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

    <script>
        let selectedDate = null;
        let editingEventId = null;
        let calendar;

        function toggleSpecialDescription() {
            const checkbox = document.querySelector('[name="is_special_event"]');
            const descriptionContainer = document.getElementById('specialDescriptionContainer');
            if (checkbox.checked) {
                descriptionContainer.classList.remove('hidden');
            } else {
                descriptionContainer.classList.add('hidden');
            }
        }

        function openModal() {
            document.getElementById('eventModal').classList.remove('hidden');

            if (selectedDate) {
                document.querySelector('[name="repeat_start"]').value = selectedDate;
                document.querySelector('[name="repeat_end"]').value = selectedDate;
            }

            toggleSpecialDescription();
        }
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const eventData = JSON.parse(document.getElementById('event-data').textContent);

            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                editable: true,
                selectable: true,
                locale: 'en',
                events: eventData,

                eventContent: function(arg) {
                    const start = arg.event.start.toLocaleTimeString([], {
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                    const end = arg.event.end ? arg.event.end.toLocaleTimeString([], {
                        hour: '2-digit',
                        minute: '2-digit'
                    }) : '';

                    const isSpecial = arg.event.extendedProps.is_special_event;
                    const label = isSpecial ? ' Special Event' : '';

                    return {
                        html: `${label}<br>${start} - ${end}`
                    };
                },


               select: function(info) {
                const eventsInRange = calendar.getEvents().filter(event => {
                    return event.start >= info.start && event.start < info.end;
                });

                const isMultiDaySelection = (info.end - info.start) / (1000 * 60 * 60 * 24) > 1;

                if (isMultiDaySelection && eventsInRange.length > 0) {
                    if (confirm(`Er zijn ${eventsInRange.length} openingstijden geselecteerd. Wil je deze verwijderen?`)) {
                        eventsInRange.forEach(event => {
                            fetch(`/schedules/${event.id}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            }).then(() => {
                                event.remove();
                            });
                        });
                    }
                } else {
                    selectedDate = info.startStr.split('T')[0];
                    editingEventId = null;
                    document.getElementById('deleteEventBtn').classList.add('hidden');
                    document.getElementById('repeat_type').value = '';
                    toggleRepeatFields();
                    openModal();
                }
            },

                eventClick: function(info) {
                    const event = info.event;
                    editingEventId = event.id;
                    selectedDate = event.start.toISOString().split('T')[0];

                    document.querySelector('[name="start_time"]').value = event.start.toTimeString().slice(0, 5);
                    document.querySelector('[name="end_time"]').value = event.end ? event.end.toTimeString().slice(0, 5) : '';
                    document.getElementById('deleteEventBtn').classList.remove('hidden');

                    const isSpecial = event.extendedProps.is_special_event;
                    const description = event.extendedProps.special_event_description;

                    document.querySelector('[name="is_special_event"]').checked = isSpecial;
                    document.querySelector('[name="special_event_description"]').value = description || '';

                    openModal(true);
                    toggleSpecialDescription();
                },
                eventDrop: function(info) {
                    fetch(`/schedules/${info.event.id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            start: info.event.start.toISOString(),
                            end: info.event.end.toISOString()
                        })
                    });
                },
            });

            calendar.render();
            document.getElementById('repeat_type').addEventListener('change', toggleRepeatFields);
        });

        function toggleRepeatFields() {
            const type = document.getElementById('repeat_type').value;
            document.getElementById('weekly-days').classList.toggle('hidden', type !== 'weekly');

            const dateFields = document.querySelectorAll('[name="repeat_start"], [name="repeat_end"]');
            dateFields.forEach(el => {
                el.closest('div').classList.toggle('hidden', type === '');
            });
        }

        function openModal(isEdit = false) {
            document.getElementById('eventModal').classList.remove('hidden');

            if (selectedDate) {
                document.querySelector('[name="repeat_start"]').value = selectedDate;
                document.querySelector('[name="repeat_end"]').value = selectedDate;
            }

            // Controleer of de beschrijving zichtbaar moet zijn
            toggleSpecialDescription();

            // Reset het beschrijvingsveld als het geen bestaande event is
            if (!isEdit) {
                document.querySelector('[name="special_event_description"]').value = '';
                document.querySelector('[name="is_special_event"]').checked = false;
                toggleSpecialDescription();
            }
        }


        function closeModal() {
            document.getElementById('eventModal').classList.add('hidden');
            document.getElementById('eventForm').reset();
            editingEventId = null;
            calendar.refetchEvents();
        }

        function generateRecurrenceDates(rule, startDateStr) {
            const match = rule.match(/FREQ=(DAILY|WEEKLY);?(BYDAY=([^;]+))?;?UNTIL=(\d{8})/);
            if (!match) return [];

            const freq = match[1];
            const byDayRaw = match[3] || '';
            const until = match[4];

            const weekdayMap = {
                'MO': 1,
                'TU': 2,
                'WE': 3,
                'TH': 4,
                'FR': 5,
                'SA': 6,
                'SU': 0
            };
            const allowedWeekdays = byDayRaw.split(',').map(d => weekdayMap[d]).filter(Boolean);

            const startDate = new Date(startDateStr);
            const endDate = new Date(until.slice(0, 4), until.slice(4, 6) - 1, until.slice(6, 8));
            endDate.setDate(endDate.getDate() + 1);

            const dates = [];
            let current = new Date(startDate);

            while (current <= endDate) {
                if (
                    (freq === 'DAILY') ||
                    (freq === 'WEEKLY' && allowedWeekdays.includes(current.getDay()))
                ) {
                    dates.push(new Date(current));
                }
                current.setDate(current.getDate() + 1);
            }

            return dates;
        }

        document.getElementById('eventForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = e.target;
            const startTime = form.start_time.value;
            const endTime = form.end_time.value;
            const isSpecialEvent = form.is_special_event.checked;
            const specialEventDescription = form.special_event_description.value || null;
            const repeatType = form.repeat_type.value;
            const startDate = selectedDate || form.repeat_start.value;
            const endDate = form.repeat_end.value;

            let recurrenceRule = null;

            // Genereer de herhalingsregel op basis van de gekozen optie
            if (repeatType === 'daily') {
                recurrenceRule = `FREQ=DAILY;UNTIL=${endDate.replace(/-/g, '')}`;
            } else if (repeatType === 'weekly') {
                const days = Array.from(document.querySelectorAll('input[name="repeat_days[]"]:checked'))
                    .map(cb => cb.value).join(',');
                if (days) {
                    recurrenceRule = `FREQ=WEEKLY;BYDAY=${days};UNTIL=${endDate.replace(/-/g, '')}`;
                }
            } else if (repeatType === 'weekdays') {
                recurrenceRule = `FREQ=WEEKLY;BYDAY=MO,TU,WE,TH,FR;UNTIL=${endDate.replace(/-/g, '')}`;
            }

            // Formatteer de start- en eindtijd
            const dateStr = startDate;
            const fullStart = `${dateStr}T${startTime}`;
            const fullEnd = `${dateStr}T${endTime}`;

            // Controleer of het een update of een nieuw evenement is
            if (editingEventId) {
                // --- Update bestaand evenement ---
                fetch(`/schedules/${editingEventId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            start: fullStart,
                            end: fullEnd,
                            is_special_event: isSpecialEvent,
                            special_event_description: specialEventDescription,
                            recurrence_rule: recurrenceRule
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        const event = calendar.getEventById(editingEventId);
                        event.setStart(fullStart);
                        event.setEnd(fullEnd);
                        event.setProp('title', isSpecialEvent ? `${specialEventDescription} <span class="special-event-label">Special Event</span>` : 'Event');
                        event.setExtendedProp('is_special_event', isSpecialEvent);
                        event.setExtendedProp('special_event_description', specialEventDescription);

                        // Toon visueel dat het een speciaal evenement is
                        if (isSpecialEvent) {
                            event.setProp('title', `🎉 ${specialEventDescription}`);
                        } else {
                            event.setProp('title', 'Event');
                        }

                        closeModal();
                    });
            } else {
                // --- Nieuw evenement aanmaken ---
                const datesToCreate = recurrenceRule ?
                    generateRecurrenceDates(recurrenceRule, startDate) : [new Date(startDate)];

                datesToCreate.forEach(dateObj => {
                    const dateStr = dateObj.toISOString().split('T')[0];
                    const fullStart = `${dateStr}T${startTime}`;
                    const fullEnd = `${dateStr}T${endTime}`;

                    fetch(`/exhibitions/{{ $record->id }}/schedules`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                start: fullStart,
                                end: fullEnd,
                                is_special_event: isSpecialEvent,
                                special_event_description: specialEventDescription,
                                recurrence_rule: recurrenceRule
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            calendar.addEvent({
                                id: data.id,
                                start: data.date + 'T' + data.start_time,
                                end: data.date + 'T' + data.end_time,
                                title: isSpecialEvent ? `🎉 ${specialEventDescription}` : 'Event',
                                allDay: false,
                                extendedProps: {
                                    is_special_event: isSpecialEvent,
                                    special_event_description: specialEventDescription
                                }
                            });
                        });
                });

                closeModal();
            }
        });


        document.getElementById('deleteEventBtn').addEventListener('click', function() {
            if (editingEventId && confirm('Are you sure you want to delete this event?')) {
                fetch(`/schedules/${editingEventId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(() => {
                    const event = calendar.getEventById(editingEventId);
                    event.remove();
                    closeModal();
                });
            }
        });
    </script>
<style>
    .special-event-label {
        display: inline-block;
        background-color: #ff6b6b;
        color: white;
        font-size: 0.75rem;
        padding: 0.2em 0.4em;
        margin-left: 0.5em;
        border-radius: 4px;
        font-weight: bold;
    }
</style>
</x-filament::page>