<template>
    <div>
        <div class="panel">
            <div class="mb-5">
                <div class="mb-4 flex items-center sm:flex-row flex-col sm:justify-between justify-center">
                    <div class="sm:mb-0 mb-4">
                        <!-- <div class="text-lg font-semibold">My Calendar Events</div> -->
                        <!-- <div class="flex items-center mt-2 flex-wrap sm:justify-start justify-center">
                            <div class="flex items-center ltr:mr-4 rtl:ml-4">
                                <div class="h-2.5 w-2.5 rounded-sm ltr:mr-2 rtl:ml-2 bg-blue-800"></div>
                                <div>Work</div>
                            </div>
                            <div class="flex items-center ltr:mr-4 rtl:ml-4">
                                <div class="h-2.5 w-2.5 rounded-sm ltr:mr-2 rtl:ml-2 bg-blue-500"></div>
                                <div>Travel</div>
                            </div>
                            <div class="flex items-center ltr:mr-4 rtl:ml-4">
                                <div class="h-2.5 w-2.5 rounded-sm ltr:mr-2 rtl:ml-2 bg-green-700"></div>
                                <div>Personal</div>
                            </div>
                            <div class="flex items-center">
                                <div class="h-2.5 w-2.5 rounded-sm ltr:mr-2 rtl:ml-2 bg-red-700"></div>
                                <div>Important</div>
                            </div>
                        </div> -->
                    </div>
                    
                </div>
                <div class="calendar-wrapper">
                    <FullCalendar ref="calendar" :options="calendarOptions" @eventDrop="eventDrop">
                        <template v-slot:eventContent="arg">
                            <div class="fc-event-main-frame flex items-center px-1 py-0.5 bg-blue-600 text-white w-full rounded-sm">
                                <div class="fc-event-time font-semibold px-0.5">
                                    {{ arg.timeText }}
                                </div>
                                <div class="fc-event-title-container">
                                    <div class="fc-event-title fc-sticky !font-medium px-0.5">
                                        {{ arg.event.title }}
                                    </div>
                                </div>
                            </div>
                        </template>
                    </FullCalendar>
                </div>
            </div>
        </div>
        <!-- add event modal -->
        <TransitionRoot appear :show="isAddEventModal" as="template">
            <Dialog as="div" @close="isAddEventModal = false" class="relative z-[51]">
                <TransitionChild
                    as="template"
                    enter="duration-300 ease-out"
                    enter-from="opacity-0"
                    enter-to="opacity-100"
                    leave="duration-200 ease-in"
                    leave-from="opacity-100"
                    leave-to="opacity-0"
                >
                    <DialogOverlay class="fixed inset-0 bg-[black]/60" />
                </TransitionChild>
  
                <div class="fixed inset-0 overflow-y-auto ">
                    <div class="flex min-h-full items-center justify-center px-4 py-8 ">
                        <TransitionChild
                            as="template"
                            enter="duration-300 ease-out"
                            enter-from="opacity-0 scale-95"
                            enter-to="opacity-100 scale-100"
                            leave="duration-200 ease-in"
                            leave-from="opacity-100 scale-100"
                            leave-to="opacity-0 scale-95"
                        >
                            <DialogPanel class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-lg text-black dark:text-white-dark bg-white">
                                
                                <div class="flex justify-between bg-blue-400 dark:bg-blue-800 text-white px-4">
                                <div class="text-lg font-medium  ltr:pl-5 rtl:pr-5 py-3 ltr:pr-[50px] rtl:pl-[50px]">
                                    {{ params.id ? 'Timetable Details ' : 'No Timetable' }}
                                    
                                </div>

                                <button
                                    type="button"
                                    class="ltr:right-4 rtl:left-4 text-white hover:text-gray-100 dark:hover:text-gray-200 outline-none"
                                    @click="isAddEventModal = false"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24px"
                                        height="24px"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="w-6 h-6"
                                    >
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </button>

                                </div>

                                <div v-if="params.id" class="px-6 py-4">
        <h1 class="text-xl font-semibold text-gray-800">{{ params.title }}</h1>

        <p class="py-2 text-gray-700 ">{{ params.description }}</p>

        <div class="flex items-center mt-4 text-gray-700 ">
            <CalendarDaysIcon class="w-6" />

            <h1 class="px-2 text-sm">From: {{ startDateAll }}</h1>
        </div>

        <div class="flex items-center mt-4 text-gray-700 ">
            <CalendarDaysIcon class="w-6" />

            <h1 class="px-2 text-sm">To: {{ endDateAll }}</h1>
        </div>

        
    </div>
                                <div v-else class="px-6 py-4">
        <!-- <h1 class="text-xl font-semibold text-gray-800"></h1> -->

        <p class="py-2 text-gray-700 ">No timetable found for the selected day!</p>
        
    </div>

    

                              
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </div>
  </template>
  
  <script setup>
  import { Link  } from '@inertiajs/vue3';
    import { computed, onMounted, ref,watch } from 'vue';
    import { TransitionRoot, TransitionChild, Dialog, DialogPanel, DialogOverlay } from '@headlessui/vue';
    import FullCalendar from '@fullcalendar/vue3';
    import dayGridPlugin from '@fullcalendar/daygrid';
    import timeGridPlugin from '@fullcalendar/timegrid';
    import interactionPlugin from '@fullcalendar/interaction';
    import Swal from 'sweetalert2';

    import { CalendarDaysIcon } from '@heroicons/vue/24/outline'
  
    const props = defineProps({
        'calendar': [Object,Array],
    })

    const defaultParams = ref({
      id: null,
      title: '',
      start: '',
      end: '',
      description: '',
      type: 'primary',
    });
    const params = ref({ ...defaultParams.value });
    const isAddEventModal = ref(false);
    const minStartDate = ref('');
    const minEndDate = ref('');
    const calendar = ref(null);
    const now = new Date();
    const events = ref([]);
    const calendarOptions = computed(() => {
      return {
        plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
        initialView: 'dayGridMonth',
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay',
        },
        editable: true,
        dayMaxEvents: true,
        selectable: true,
        droppable: true,
        eventClick: event => {
          editEvent(event);
        },
        select: event => {
          editDate(event);
        },
        events: events.value,
      };
    });
  
    onMounted(() => {
      getEvents();
    });
  
    const getEvents = () => {
        events.value = props.calendar
    };
  
    const getMonth = (dt, add = 0) => {
      let month = dt.getMonth() + 1 + add;
      return (month < 10 ? '0' + month : month).toString();
    };
  

    const eventDrop = (info) => {
    // 'info' contains information about the dropped event, such as its new start and end times.
    let event = events.value.find(e => e.id === Number(info.event.id));
    if (event) {
        event.start = info.event.startStr; // Assuming 'startStr' is the correct property
        event.end = info.event.endStr;   // Assuming 'endStr' is the correct property
        // Call a method to update the event in your backend or perform other actions
    }
};

    const editEvent = (data = null) => {
    params.value = JSON.parse(JSON.stringify(defaultParams.value));
    
    if (data) {
        let obj = JSON.parse(JSON.stringify(data.event));
        params.value = {
            id: obj.id ? obj.id : null,
            title: obj.title ? obj.title : null,
            start: dateFormat(obj.start),
            end: dateFormat(obj.end),
            type: obj.types ? obj.types[0] : 'primary',
            description: obj.extendedProps ? obj.extendedProps.description : '',
        };
        minStartDate.value = new Date();
        minEndDate.value = dateFormat(obj.start);
    } else {
        minStartDate.value = new Date();
        minEndDate.value = new Date();
    }

    isAddEventModal.value = true;
};

  
    const editDate = data => {
      let obj = {
        event: {
          start: data.start,
          end: data.end,
        },
      };
      editEvent(obj);
    };
  
    const dateFormat = dt => {
      dt = new Date(dt);
      // ... format date ...
      const month = (dt.getMonth() + 1).toString().padStart(2, '0');
      const date = dt.getDate().toString().padStart(2, '0');
      const hours = dt.getHours().toString().padStart(2, '0');
      const mins = dt.getMinutes().toString().padStart(2, '0');
      return `${dt.getFullYear()}-${month}-${date}T${hours}:${mins}`;
    };
  
    const postCalendar = async (calendarData) => {
    
};

const deleteCalendar = async (cal) => {
   
};




    const saveEvent = () => {
     

     
    };

    const removeEvent = (eventId) => {
        deleteCalendar(eventId)
    };

  
    const startDateChange = event => {
      const dateStr = event.target.value;
      if (dateStr) {
        minEndDate.value = dateFormat(dateStr);
        params.value.end = '';
      }
    };
  
    const showMessage = (msg = '', type = 'success') => {
      Swal.fire({
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: 10000,
        icon: type,
        title: msg,
        customClass: { container: 'toast' },
      });
    };

    const formatDateTime = (dateStr) => {
  // Replace potential problematic characters
//   const adjustedDateStr = dateStr.replace(' ', 'T');

  // Parse the adjusted date string
  const date = new Date(dateStr);
  if (isNaN(date)) {
    return 'Invalid Date';
  }

  const options = { 
    year: 'numeric', 
    month: 'long', 
    day: 'numeric', 
    hour: 'numeric', 
    minute: '2-digit', 
    hour12: true 
  };

  return new Intl.DateTimeFormat('en-US', options).format(date);
};

// console.log('the start '+ params.start.value)

const startDateAll = ref('');

watch(() => params.value.start, (newStart) => {
  if (newStart && newStart.trim() !== '') {
    try {
      startDateAll.value = formatDateTime(newStart);
    } catch (error) {
      console.error('Error formatting date:', error);
      startDateAll.value = ''; // Fallback in case of an error
    }
  } else {
    console.log('Received an empty or invalid start date:', newStart);
    startDateAll.value = ''; // Set to empty if the newStart is not a valid date
  }
}, { immediate: true });


const endDateAll = ref('');

watch(() => params.value.start, (newStart) => {
  if (newStart && newStart.trim() !== '') {
    try {
        endDateAll.value = formatDateTime(newStart);
    } catch (error) {
      console.error('Error formatting date:', error);
      endDateAll.value = ''; // Fallback in case of an error
    }
  } else {
    console.log('Received an empty or invalid start date:', newStart);
    endDateAll.value = ''; // Set to empty if the newStart is not a valid date
  }
}, { immediate: true });



  </script>
  
  
  