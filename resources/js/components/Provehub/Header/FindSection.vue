<template>

   
<div class="container mx-auto">
        
    </div>
    <div class=" ">
    
    <ul role="list" class="divide-y divide-gray-300">
      <li  class="px-3 py-2">
    <TabGroup as="div">
    <div class="border-b border-gray-200 flex overflow-x-scroll ">
    <TabList class="-mb-px flex space-x-2   ">
      <Tab as="template" v-slot="{ selected }" >
        <button :class="[selected ? 'inline-flex items-center h-12 px-2 py-2 text-center text-gray-700 border-4 sm:px-4  rounded-t-lg -px-1  whitespace-nowrap focus:border-yellow-500 bg-white' : '','inline-flex items-center h-12 px-2 py-2 text-center text-gray-700 bg-transparent sm:px-4  -px-1  whitespace-nowrap cursor-base focus:outline-none hover:border-gray-400  bg-white']">
    
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-suitcase2-fill" viewBox="0 0 16 16">
      <path d="M6.5 0a.5.5 0 0 0-.5.5V3H4.5A1.5 1.5 0 0 0 3 4.5v9a1.5 1.5 0 0 0 1.003 1.416A1 1 0 1 0 6 15h4a1 1 0 1 0 1.996-.084A1.5 1.5 0 0 0 13 13.5v-9A1.5 1.5 0 0 0 11.5 3H10V.5a.5.5 0 0 0-.5-.5zM9 3H7V1h2zM4 7V6h8v1z"/>
    </svg>
    
    
            <span class="mx-1 text-sm sm:text-base">
                Vacation Packages
            </span>
        </button>
      </Tab>
      <Tab as="template" v-slot="{ selected }" class="flex overflow-x-auto whitespace-nowrap">
        <button :class="[selected ? 'inline-flex items-center h-12 px-2 py-2 text-center text-gray-700 border-4 sm:px-4  rounded-t-lg -px-1  whitespace-nowrap focus:border-yellow-500 bg-white' : '','inline-flex items-center h-12 px-2 py-2 text-center text-gray-700 bg-transparent sm:px-4  -px-1  whitespace-nowrap cursor-base focus:outline-none hover:border-gray-400  bg-white']"> 
    
    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="0.5" stroke="currentColor" class="w-4 h-4">
      <path fill-rule="evenodd" d="M5.166 2.621v.858c-1.035.148-2.059.33-3.071.543a.75.75 0 0 0-.584.859 6.753 6.753 0 0 0 6.138 5.6 6.73 6.73 0 0 0 2.743 1.346A6.707 6.707 0 0 1 9.279 15H8.54c-1.036 0-1.875.84-1.875 1.875V19.5h-.75a2.25 2.25 0 0 0-2.25 2.25c0 .414.336.75.75.75h15a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-2.25-2.25h-.75v-2.625c0-1.036-.84-1.875-1.875-1.875h-.739a6.706 6.706 0 0 1-1.112-3.173 6.73 6.73 0 0 0 2.743-1.347 6.753 6.753 0 0 0 6.139-5.6.75.75 0 0 0-.585-.858 47.077 47.077 0 0 0-3.07-.543V2.62a.75.75 0 0 0-.658-.744 49.22 49.22 0 0 0-6.093-.377c-2.063 0-4.096.128-6.093.377a.75.75 0 0 0-.657.744Zm0 2.629c0 1.196.312 2.32.857 3.294A5.266 5.266 0 0 1 3.16 5.337a45.6 45.6 0 0 1 2.006-.343v.256Zm13.5 0v-.256c.674.1 1.343.214 2.006.343a5.265 5.265 0 0 1-2.863 3.207 6.72 6.72 0 0 0 .857-3.294Z" clip-rule="evenodd" />
    </svg>
    
    
    
            <span class="mx-1 text-sm sm:text-base">
                Contest
            </span>
        </button>
      </Tab>
      <Tab as="template" v-slot="{ selected }">
        <button :class="[selected ? 'inline-flex items-center h-12 px-2 py-2 text-center text-gray-700 border-4 sm:px-4  rounded-t-lg -px-1  whitespace-nowrap focus:border-yellow-500 bg-white' : '','inline-flex items-center h-12 px-2 py-2 text-center text-gray-700 bg-transparent sm:px-4  -px-1  whitespace-nowrap cursor-base focus:outline-none hover:border-gray-400  bg-white']"> 
    
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mx-1 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor"><path d="M23,9.32a1.06,1.06,0,0,0-.1-.76,4.93,4.93,0,0,0-6.75-1.8L14,8,9,5.65a1,1,0,0,0-.92,0l-3,1.73a1,1,0,0,0-.5.84,1,1,0,0,0,.46.87l3.3,2.08-1.74,1-4.78.58a1,1,0,0,0-.53,1.75l3.54,3.06a3,3,0,0,0,3.55.44L22.5,9.93A1,1,0,0,0,23,9.32Zm-15.53,7a1,1,0,0,1-1.2-.18L4.37,14.51l2.73-.33a1,1,0,0,0,.38-.13l3.36-1.93a1,1,0,0,0,.5-.85,1,1,0,0,0-.47-.86L7.57,8.32l1.1-.63,5,2.32a1,1,0,0,0,.92,0l2.56-1.48a3,3,0,0,1,3.36.29Z"/></svg>
    
    
            <span class="mx-1 text-sm sm:text-base">
                Flight
            </span>
        </button>
      </Tab>
      
    </TabList>
    </div>
    <TabPanels as="template" >
    
    
    <TabPanel class="rounded-md border bg-white border-t-0 rounded-t-none">


      <div class="flex flex-col sm:flex-row justify-between py-1 px-4">
      <div class="flex flex-col sm:flex-row justify-center text-center py-4 gap-4">

        <div class="sm:col-span-2 sm:col-start-1">
          <label for="city" class="block text-sm font-medium leading-6 text-gray-900">Country</label>
          <div class="mt-2">
            <LocationBar />
          </div>
        </div>

        <div class="sm:col-span-2">
          <label for="region" class="block text-sm font-medium leading-6 text-gray-900">From</label>
          <div class="mt-2">
            <input id="dateStart" type="date" name="start" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-yellow-600 sm:text-sm sm:leading-6" placeholder="Event Start Date"
                        :min="minStartDate"
                        required />
          </div>
        </div>

        <div class="sm:col-span-2">
          <label for="postal-code" class="block text-sm font-medium leading-6 text-gray-900">To</label>
          <div class="mt-2">
            <input id="dateStart" type="date" name="start" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-yellow-600 sm:text-sm sm:leading-6" placeholder="Event Start Date"
                        :min="minStartDate"
                        required />
          </div>
        </div>


        <div class="sm:col-span-2">
            <label class="block text-sm font-medium leading-6 text-gray-900">Price range</label>
                <VueSimpleRangeSlider
                style="width: 170px"
                :min="10"
                :max="900"
                exponential
                v-model="state.range"
            >
                <template #prefix="{ value }">$</template>
            </VueSimpleRangeSlider>
        </div>
    </div>

        <div class="sm:col-span-2 py-8">
            <Link
                class="inline-block rounded-full border border-yellow-600 bg-yellow-600 p-3 text-white hover:bg-yellow-900 hover:text-yellow-600 focus:outline-none focus:ring active:text-yellow-500"
                :href="route('search.destination')"
                >
                <span class="sr-only"> Download </span>

                <MagnifyingGlassIcon class="h-5 w-5 text-white" aria-hidden="true" />
        </Link>
        </div>


    
            
           
        </div>
    </TabPanel>
    <TabPanel class="rounded-md border bg-white border-t-0 rounded-t-none">


      <div class="flex flex-col sm:flex-row justify-between py-1 px-4">
  <div class="flex flex-col sm:flex-row justify-center text-center py-4 gap-4">

            <div class="sm:col-span-2 sm:col-start-1">
          <label for="city" class="block text-sm font-medium leading-6 text-gray-900">Country</label>
          <div class="mt-2">
            <LocationBar />
          </div>
        </div>

        <div class="sm:col-span-2">
          <label for="region" class="block text-sm font-medium leading-6 text-gray-900">From</label>
          <div class="mt-2">
            <input id="dateStart" type="date" name="start" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-yellow-600 sm:text-sm sm:leading-6" placeholder="Event Start Date"
                        :min="minStartDate"
                        required />
          </div>
        </div>

        <div class="sm:col-span-2">
          <label for="postal-code" class="block text-sm font-medium leading-6 text-gray-900">To</label>
          <div class="mt-2">
            <input id="dateStart" type="date" name="start" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-yellow-600 sm:text-sm sm:leading-6" placeholder="Event Start Date"
                        :min="minStartDate"
                        required />
          </div>
        </div>


        <div class="sm:col-span-2">
            <label class="block text-sm font-medium leading-6 text-gray-900">Price range</label>
                <VueSimpleRangeSlider
                style="width: 170px"
                :min="10"
                :max="900"
                exponential
                v-model="state.range"
            >
                <template #prefix="{ value }">$</template>
            </VueSimpleRangeSlider>
        </div>
    </div>

        <div class="sm:col-span-2 py-8">
          <Link
                class="inline-block rounded-full border border-yellow-600 bg-yellow-600 p-3 text-white hover:bg-yellow-900 hover:text-yellow-600 focus:outline-none focus:ring active:text-yellow-500"
                :href="route('search.destination')"
                >
                <span class="sr-only"> Download </span>

                <MagnifyingGlassIcon class="h-5 w-5 text-white" aria-hidden="true" />
        </Link>
        </div>


    
            
           
        </div>
    </TabPanel>
    

    <TabPanel class="rounded-md border bg-white border-t-0 rounded-t-none">

<div>
    <RadioGroup v-model="mem" class="py-2 px-2">
        <RadioGroupLabel class="sr-only">Choose a memory option</RadioGroupLabel>
        <div class="grid grid-cols-3 gap-3 sm:grid-cols-6">
            <RadioGroupOption as="template" v-for="option in memoryOptions" :key="option.name" :value="option" :disabled="!option.inStock" v-slot="{ active, checked }">
            <div :class="[option.inStock ? 'cursor-pointer focus:outline-none' : 'cursor-not-allowed opacity-25', active ? 'ring-2 ring-indigo-600 ring-offset-2' : '', checked ? 'bg-indigo-600 text-white hover:bg-indigo-500' : 'ring-1 ring-inset ring-gray-300 bg-white text-gray-900 hover:bg-gray-50', 'flex items-center justify-center rounded-md py-2 px-2 text-sm font-semibold sm:flex-1']">
                <RadioGroupLabel as="span">{{ option.name }}</RadioGroupLabel>
            </div>
            </RadioGroupOption>
        </div>
        </RadioGroup>
    </div>

    <div v-if="mem">
<!-- round trip -->
<div v-if="mem['id'] == 1">
  <form @submit.prevent="upload">

    <div class="flex flex-col sm:flex-row justify-between py-1 px-4">
  <div class="flex flex-col sm:flex-row justify-center text-center py-4 gap-4">


    

    <div class="sm:col-span-2 sm:col-start-1">
        <label class="block text-sm font-medium leading-6 text-gray-900">Departing</label>
        <v-select 
        class="w-40" 
            placeholder="Select airport..."
            v-model="form.departing"
            :options="addAirports" 
            label="combinedLabel"
            track-by="id"
            close-on-select 
            :filterable="true"
            :loading="loadingAirports.value"
            loadingSlot="Loading Airports...">
        </v-select>

</div>

    <div class="sm:col-span-2 sm:col-start-1">
        <label class="block text-sm font-medium leading-6 text-gray-900">Arriving</label>
        <v-select 
        class="w-40" 
            placeholder="Select airport..."
            v-model="form.arriving"
            :options="addAirports" 
            label="combinedLabel"
            track-by="id"
            close-on-select 
            :filterable="true"
            :loading="loadingAirports.value"
            loadingSlot="Loading Airports...">
        </v-select>

</div>

<div class="sm:col-span-2">
  <label class="block text-sm font-medium leading-6 text-gray-900">Departure Date</label>
  <div>
    <input id="dateStart" type="date" v-model="form.departing_date" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-yellow-600 sm:text-sm sm:leading-6" placeholder="Event Start Date"
                :min="minStartDate"
                required />
  </div>
</div>

<div class="sm:col-span-2">
  <label for="postal-code" class="block text-sm font-medium leading-6 text-gray-900">Return Date</label>
  <div>
    <input id="dateStart" type="date" name="start" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-yellow-600 sm:text-sm sm:leading-6" placeholder="Event Start Date"
                :min="minStartDate"
                required />
  </div>
</div>

<div class="sm:col-span-2">
    


  <label for="postal-code" class="block text-sm font-medium leading-6 text-gray-900">Passengers</label>
   <Menu as="div" class="relative inline-block text-left ml-4">
      <div>
        <MenuButton class="group inline-flex justify-center text-lg font-medium text-gray-700 hover:text-gray-900">
            <div class="flex justify-between gap-4">
                <UserCircleIcon class="-mr-1 ml-1 h-7 w-7 flex-shrink-0 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
                <h2>{{ count }}</h2>
            </div>
          <ChevronDownIcon class="-mr-1 ml-1 h-7 w-7 flex-shrink-0 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
        </MenuButton>
      </div>

      <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
        <MenuItems class="absolute z-10 mt-2 w-60 origin-top-right rounded-md bg-white shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none">
          <div class="py-1">
            <!-- place items here -->
            <ul class="space-y-1 border-t border-gray-200 p-4">
    <li>
        <div class="flex justify-between">
        <div>
            <h3>Adult</h3>
            <p class="block text-sm leading-6 text-gray-900">(&lt; 11 years)</p>
        </div>
        <div class="flex items-center space-x-2">
            <button type="button"
                class="px-3 py-1 bg-gray-200 text-gray-800 rounded hover:bg-gray-300"
                @click.prevent="decrement"
            >
                -
            </button>
        
            <input
                type="text"
                readonly
                class="w-12 text-center bg-gray-100 rounded border border-gray-200"
                :value="count"
            />
        
            <button type="button"
                class="px-3 py-1 bg-gray-200 text-gray-800 rounded hover:bg-gray-300"
                @click.prevent="increment"
            >
                +
            </button>
            </div>
        </div>
    </li>


</ul>
            <!-- place items here -->
          </div>
        </MenuItems>
      </transition>
    </Menu>
</div>


</div>

<div class="sm:col-span-2 py-8">
    <button
        class="inline-block rounded-full border border-yellow-600 bg-yellow-600 p-3 text-white hover:bg-yellow-900 hover:text-yellow-600 focus:outline-none focus:ring active:text-yellow-500"
        type="submit"
        >
        <span class="sr-only"> Download </span>

        <MagnifyingGlassIcon class="h-5 w-5 text-white" aria-hidden="true" />
        </button>
</div>



    
   
</div>
</form>
</div>
<!-- One Way -->
<div v-if="mem['id'] == 2">


  <form @submit.prevent="upload">
    <div class="flex flex-col sm:flex-row justify-between py-1 px-4">
  <div class="flex flex-col sm:flex-row justify-center text-center py-4 gap-4">

    <div class="sm:col-span-2 sm:col-start-1">
        <label class="block text-sm font-medium leading-6 text-gray-900">Departing</label>
        <v-select 
        class="w-40" 
            placeholder="Select airport..."
            v-model="form.departing"
            :options="addAirports" 
            label="combinedLabel"
            track-by="id"
            close-on-select 
            :filterable="true"
            :loading="loadingAirports.value"
            loadingSlot="Loading Airports...">
        </v-select>

</div>

    <div class="sm:col-span-2 sm:col-start-1">
        <label class="block text-sm font-medium leading-6 text-gray-900">Arriving</label>
        <v-select 
        class="w-40" 
            placeholder="Select airport..."
            v-model="form.arriving"
            :options="addAirports" 
            label="combinedLabel"
            track-by="id"
            close-on-select 
            :filterable="true"
            :loading="loadingAirports.value"
            loadingSlot="Loading Airports...">
        </v-select>

</div>

<div class="sm:col-span-2">
  <label class="block text-sm font-medium leading-6 text-gray-900">Departure Date</label>
  <div>
    <input id="dateStart" type="date" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-yellow-600 sm:text-sm sm:leading-6" placeholder="Event Start Date"
    v-model="form.departing_date"
                :min="minStartDate"
                required />
  </div>
</div>



<div class="sm:col-span-2">
    


  <label for="postal-code" class="block text-sm font-medium leading-6 text-gray-900">Passengers</label>
   <Menu as="div" class="relative inline-block text-left ml-4">
      <div>
        <MenuButton class="group inline-flex justify-center text-lg font-medium text-gray-700 hover:text-gray-900">
            <div class="flex justify-between gap-4">
                <UserCircleIcon class="-mr-1 ml-1 h-7 w-7 flex-shrink-0 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
                <h2>{{ count }}</h2>
            </div>
          <ChevronDownIcon class="-mr-1 ml-1 h-7 w-7 flex-shrink-0 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
        </MenuButton>
      </div>

      <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
        <MenuItems class="absolute z-10 mt-2 w-60 origin-top-right rounded-md bg-white shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none">
          <div class="py-1">
            <!-- place items here -->
            <ul class="space-y-1 border-t border-gray-200 p-4">
    <li>
        <div class="flex justify-between">
        <div>
            <h3>Adult</h3>
            <p class="block text-sm leading-6 text-gray-900">(&lt; 11 years)</p>
        </div>
        <div class="flex items-center space-x-2">
            <!-- Decrement button -->
            <button
                class="px-3 py-1 bg-gray-200 text-gray-800 rounded hover:bg-gray-300"
                @click.prevent="decrement"
            >
                -
            </button>
        
            <!-- Display the current value -->
            <input
                type="text"
                readonly
                class="w-12 text-center bg-gray-100 rounded border border-gray-200"
                :value="count"
            />
        
            <!-- Increment button -->
            <button
                class="px-3 py-1 bg-gray-200 text-gray-800 rounded hover:bg-gray-300"
                @click.prevent="increment"
            >
                +
            </button>
            </div>
        </div>
    </li>


</ul>
            <!-- place items here -->
          </div>
        </MenuItems>
      </transition>
    </Menu>
</div>


</div>

<div class="sm:col-span-2 py-8">
    <button
        class="inline-block rounded-full border border-yellow-600 bg-yellow-600 p-3 text-white hover:bg-gray-400 hover:text-yellow-600 focus:outline-none focus:ring active:text-yellow-500"
        type="submit"
        >
        <span class="sr-only"> Download </span>

        <MagnifyingGlassIcon class="h-5 w-5 text-white" aria-hidden="true" />
        </button>
</div>



    
</div>
</form>
</div>



</div>
</TabPanel>
    
    </TabPanels>
    </TabGroup>
    </li>
    </ul>
    </div>
    
    
    
    
    
    
      </template>
      
      <script setup>
    
    import { StarIcon,CheckBadgeIcon,ChevronUpIcon, ChevronDownIcon, MagnifyingGlassIcon } from '@heroicons/vue/20/solid'
       import { ClockIcon, GlobeAltIcon,XMarkIcon,MapIcon,EnvelopeIcon,PhoneIcon, UserCircleIcon } from '@heroicons/vue/24/outline'


    
       import { ref,onMounted,reactive, watch } from 'vue';
       import { Link,useForm } from '@inertiajs/vue3';

       import VueSimpleRangeSlider from "vue-simple-range-slider";
        import "vue-simple-range-slider/css";

        import vSelect from 'vue-select';

       import LocationBar from '@/Components/Header/LocationBar.vue';
    
       import {
     Tab,
     TabGroup,
     TabList,
     TabPanel,
     TabPanels,Menu,
  MenuButton,
  MenuItem,
  MenuItems,
  TransitionChild,
  TransitionRoot,RadioGroup, RadioGroupLabel, RadioGroupOption
    } from '@headlessui/vue'
    

     
      const tabs = [
        { name: 'My Account', href: '#', current: true },
        { name: 'Company', href: '#', current: false },
        { name: 'Team Members', href: '#', current: false },
        { name: 'Billing', href: '#', current: false },
      ]


      const minStartDate = ref('');
      // Function to format the current date to YYYY-MM-DD
        const formatDate = (date) => {
        const year = date.getFullYear();
        const month = date.getMonth() + 1; // getMonth() is zero-based
        const day = date.getDate();
        // Pad the month and day with leading zeros if necessary
        return `${year}-${month.toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;
        };

        // Set the minimum start date to today's date
        minStartDate.value = formatDate(new Date());

        const state = reactive({ range: [20, 1000], number: 10 });


        const addAirports = ref([]);

// Assuming `loadingAirports` is reactive
const loadingAirports = ref(false);

onMounted(async () => {
    try {
        loadingAirports.value = true;
        const c = route('extra.get.airports.search'); // Make sure this route correctly points to your data source
        const response = await axios.get(c);
        if (response.status === 200) {
            addAirports.value = response.data.map(airport => ({
                ...airport,
                combinedLabel: `${airport.code} - ${airport.name}`
            }));
        } else {
            // handle error
            console.error('Failed to fetch airports', response.status);
        }
    } catch (error) {
        console.error('Error fetching airports', error);
        // handle error
    } finally {
        loadingAirports.value = false;
    }
});




// State for the count
const count = ref(0);
  
  // Increment function
  const increment = () => {
    count.value++;
  };
  
  // Decrement function
  const decrement = () => {
    if (count.value > 0) {
      count.value--;
    }
  };

  

  const memoryOptions = [
  { id: 1, name: 'Round Trip', inStock: true },
  { id: 2, name: 'One Way', inStock: true },
]

const mem = ref(memoryOptions[0])


const form = useForm({
        departing: '',
        arriving: '',
        departing_date: '',
        adult: count.value,
  });

    const upload = () => {
      form.post(
        route('search.flight.api'),
        {
          preserveScroll: true,
          onSuccess: () => {
            form.reset();
          },
        },
      )
    }
    

    // Watch the count and update form.adult whenever count changes
watch(count, (newValue) => {
  form.adult = newValue;
}, {
  immediate: true, // This ensures the watcher is also fired immediately with the current value
});

      </script>

<style>
@import "vue-select/dist/vue-select.css";
</style>