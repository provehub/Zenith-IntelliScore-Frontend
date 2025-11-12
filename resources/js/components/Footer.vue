<template>   
<!-- component -->
<!-- This is an example component -->
<div class="mt-10"></div>
<img src="/images/city.svg"/>
<div class=" -mt-8">
    <div class="max-w-2xl mx-auto text-white py-10">
        <div class="text-center">
            <h3 class="text-3xl mb-3"> Download our mobile app </h3>
            <p> Stay connected. All day, every day. </p>
            <div class="flex justify-center my-10">
                <a href="#" target="_blank" class="flex items-center border w-auto rounded-lg px-4 py-2 mx-2">
                    <img src="https://cdn-icons-png.flaticon.com/512/888/888857.png" class="w-7 md:w-8">
                    <div class="text-left ml-3">
                        <p class='text-xs text-gray-200'>Download on </p>
                        <p class="text-sm md:text-base"> Google Play Store </p>
                    </div>
                </a>
            </div>
        </div>
        <div class="mt-28 flex flex-col md:flex-row md:justify-between items-center text-sm text-gray-400">
            <p class="order-2 md:order-1 mt-8 md:mt-0"> &copy; Zenith IntelliScore, {{ $page.props.site.year }}. </p> 
            <div class="order-1 md:order-2">
                <span class="px-2">About us</span>
                <span class="px-2 border-l">Contact us</span>
                <span class="px-2 border-l">Privacy Policy</span>
            </div>
        </div>
    </div>
</div>
  
</template>
