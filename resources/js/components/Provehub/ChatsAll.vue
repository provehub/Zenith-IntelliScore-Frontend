<template>
  <div class="">
      <div class="flex gap-5 relative sm:h-[calc(100vh_-_150px)] h-full sm:min-h-0 " :class="{ 'min-h-[999px]': isShowChatMenu }">
          <div
              class="panel p-4 flex-none max-w-xs w-full absolute xl:relative z-10 space-y-4 h-full hidden xl:block overflow-hidden rounded-md shadow-md"
              :class="isShowChatMenu && '!block !overflow-y-auto'"
          >
              <div class="flex justify-between items-center ">
                  <div class="flex items-center">
                      <div class="flex-none">
                        <img :src="$page.props.auth.user.img" class="rounded-full h-12 w-12 object-cover" />
                      </div>
                      <div class="mx-3">
                          <p class="mb-1 font-semibold">{{ $page.props.auth.user.name }}</p>
                          <p class="text-xs text-white-dark">My Chats</p>
                      </div>
                  </div>
                  <div class="dropdown">
                    <!-- add some option if needed -->
                  </div>
              </div>
              <div class="relative">

                <div class="relative flex flex-grow items-stretch focus-within:z-10">
          <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
            <MagnifyingGlassCircleIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
          </div>
          <input v-model="searchUser" type="text" name="search" id="search" class="block w-full rounded-none rounded-l-md rounded-r-md border-blue-300 pl-10 focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Search message... " />
        </div>
              </div>
             
              <div class="h-px w-full border-b border-gray-200 dark:border-gray-300"></div>
              <div class="!mt-0">
                <div
    class="chat-users relative h-full min-h-[100px] sm:h-[calc(106vh_-_357px)] space-y-0.5 ltr:pr-3.5 rtl:pl-3.5 ltr:-mr-3.5 rtl:-ml-3.5 overflow-y-auto"
>
                      <template v-for="person in searchUsers" :key="person.id">
                        <!-- if not owner -->
                          <button v-if="$page.props.auth.user.id !== person.owner.user_id"
                              type="button"
                              class="w-full flex justify-between items-center p-2 hover:bg-blue-200 dark:hover:bg-gray-300 rounded-md dark:hover:text-primary hover:text-primary mt-4"
                              :class="{
                                  'bg-blue-200 dark:bg-blue-300 dark:text-primary text-primary': selectedUser && selectedUser.id === person.id,
                              }"
                              @click="selectUser(person)"
                          >
                              <div class="flex-1">
                                  <div class="flex items-center">
                                      <div class="flex-shrink-0 relative">
                                          <img :src="person.owner.user.img" class="rounded-full h-12 w-12 object-cover" />
                                          <!-- comeback -->

                                          <template v-if="person.receiver.last_login_status === 'Active'">
                                              <div class="absolute bottom-0 ">
                                                  <div class="w-3 h-3 bg-green-300 rounded-full"></div>
                                              </div>
                                          </template>
                                      </div>
                                      <div class="mx-auto ">
                                          <p class="mb-1 font-semibold">{{ person.owner.name }}</p>
                                          <p class="text-xs text-white-dark truncate max-w-[185px]">    {{ person.oldest_messages.length > 0 ? person.oldest_messages[person.oldest_messages.length - 1].body : '' }}</p>
                                      </div>
                                  </div>
                              </div>
                              <div class="font-semibold whitespace-nowrap text-xs">
                                  <p>    {{ person.oldest_messages.length > 0 ? person.oldest_messages[person.oldest_messages.length - 1].time : '' }}
</p>
                              </div>
                          </button>
                          <!-- ends -->
                        <!-- if owner -->
                          <button v-if="$page.props.auth.user.id === person.owner.user_id"
                              type="button"
                              class="w-full flex justify-between items-center p-2 hover:bg-blue-200 dark:hover:bg-gray-300 rounded-md dark:hover:text-primary hover:text-primary mt-4"
                              :class="{
                                  'bg-blue-200 dark:bg-blue-300 dark:text-primary text-primary': selectedUser && selectedUser.id === person.id,
                              }"
                              @click="selectUser(person)"
                          >
                              <div class="flex-1">
                                  <div class="flex items-center">
                                      <div class="flex-shrink-0 relative">
                                          <img :src="person.sender.img" class="rounded-full h-12 w-12 object-cover" />

                                          <template v-if="person.sender.last_login_status == 'Active'">
                                              <div class="absolute bottom-0 ">
                                                  <div class="w-3 h-3 bg-green-300 rounded-full"></div>
                                              </div>
                                          </template>
                                      </div>
                                      <div class="mx-auto ">
                                          <p class="mb-1 font-semibold">{{ person.sender.name }}</p>
                                          <p class="text-xs text-white-dark truncate max-w-[185px]">    {{ person.oldest_messages.length > 0 ? person.oldest_messages[person.oldest_messages.length - 1].body : '' }}</p>
                                      </div>
                                  </div>
                              </div>
                              <div class="font-semibold whitespace-nowrap text-xs">
                                  <p>    {{ person.oldest_messages.length > 0 ? person.oldest_messages[person.oldest_messages.length - 1].time : '' }}
</p>
                              </div>
                          </button>
                          <!-- ends -->
                      </template>
                    </div>
              </div>
          </div>
          <div
              class="bg-white z-[5] w-full h-full absolute rounded-md hidden "
              :class="isShowChatMenu && '!block xl:!hidden'"
              @click="isShowChatMenu = !isShowChatMenu"
          ></div>
          <div class="panel p-0 flex-1 rounded-md shadow-md">
              <template v-if="!isShowUserChat">
                  <div class="flex items-center justify-center h-full relative p-4">
                      <button
                          type="button"
                          class="flex xl:hidden absolute top-4 ltr:left-4 rtl:right-4 hover:text-primary"
                          @click="isShowChatMenu = !isShowChatMenu"
                      >
                          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6">
                              <path d="M20 7L4 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                              <path opacity="0.5" d="M20 12L4 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                              <path d="M20 17L4 17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                          </svg> Chats
                      </button>

                      <div class="py-8 flex items-center justify-center flex-col">
                        <section class="hidden sm:flex flex-col flex-auto border-l border-gray-800">
        <div class="my-auto mx-auto">
            <div class="inline-flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-16 h-16">
                    <path d="M4.913 2.658c2.075-.27 4.19-.408 6.337-.408 2.147 0 4.262.139 6.337.408 1.922.25 3.291 1.861 3.405 3.727a4.403 4.403 0 00-1.032-.211 50.89 50.89 0 00-8.42 0c-2.358.196-4.04 2.19-4.04 4.434v4.286a4.47 4.47 0 002.433 3.984L7.28 21.53A.75.75 0 016 21v-4.03a48.527 48.527 0 01-1.087-.128C2.905 16.58 1.5 14.833 1.5 12.862V6.638c0-1.97 1.405-3.718 3.413-3.979z" />
                    <path d="M15.75 7.5c-1.376 0-2.739.057-4.086.169C10.124 7.797 9 9.103 9 10.609v4.285c0 1.507 1.128 2.814 2.67 2.94 1.243.102 2.5.157 3.768.165l2.782 2.781a.75.75 0 001.28-.53v-2.39l.33-.026c1.542-.125 2.67-1.433 2.67-2.94v-4.286c0-1.505-1.125-2.811-2.664-2.94A49.392 49.392 0 0015.75 7.5z" />
                </svg>
                <p> You don't have any support </p>
            </div>
        </div>   
    </section>
                      </div>
                  </div>
              </template>
              <template v-if="isShowUserChat && selectedUser">
                
                  <div class="relative h-full">
                      <div v-if="$page.props.auth.user.id !== selectedUser.user2_id" class="flex justify-between items-center p-4">
                          <div class="flex items-center space-x-2 rtl:space-x-reverse">
                              <button type="button" class="xl:hidden hover:text-primary" @click="isShowChatMenu = !isShowChatMenu">
                                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6">
                                      <path d="M20 7L4 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                      <path opacity="0.5" d="M20 12L4 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                      <path d="M20 17L4 17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                  </svg>
                              </button>
                              <div class="relative flex-none">
                                <img :src="selectedUser.owner.user.img" class="rounded-full w-10 h-10 sm:h-12 sm:w-12 object-cover" />
                                  <div class="absolute bottom-0 ltr:right-0 rtl:left-0">
                                      <div class="w-4 h-4 bg-success rounded-full"></div>
                                  </div>
                              </div>
                              <div class="mx-3">
                                  <p class="font-semibold">{{ selectedUser.owner.name }}</p>
                                  <p class="text-white-dark text-xs">
                                  {{ selectedUser.receiver.last_login_status === 'Active' ? 'Active now' : 'Last seen ' + selectedUser.receiver.last_login_status }}
                              </p>
                              </div>
                          </div>
                          <!-- check for owner not equal -->
                          <div class="flex sm:gap-5 gap-3">
                            <a :href="route('listing.show',selectedUser.listing.slug)" target="_blank" class="inline-flex items-center gap-2 rounded border border-blue-600 px-4 py-2 bg-blue-600 text-white hover:bg-white hover:text-blue-600 focus:outline-none focus:ring active:bg-blue-500">
                            <span class="text-md font-medium">View Listing</span>
                            <svg class="h-5 w-5 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                           

                             

                              <div class="dropdown">
                                 <!-- hey -->
                              </div>
                          </div>

                          

                      </div>

                      <!-- v-else here -->
                      <div v-else class="flex justify-between items-center p-4">
                          <div class="flex items-center space-x-2 rtl:space-x-reverse">
                              <button type="button" class="xl:hidden hover:text-primary" @click="isShowChatMenu = !isShowChatMenu">
                                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6">
                                      <path d="M20 7L4 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                      <path opacity="0.5" d="M20 12L4 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                      <path d="M20 17L4 17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                  </svg>
                              </button>
                              <div class="relative flex-none">
                                <img :src="selectedUser.sender.img" class="rounded-full w-10 h-10 sm:h-12 sm:w-12 object-cover" />
                                  <div class="absolute bottom-0 ltr:right-0 rtl:left-0">
                                      <div class="w-4 h-4 bg-success rounded-full"></div>
                                  </div>
                              </div>
                              <div class="mx-3">
                                  <p class="font-semibold">{{ selectedUser.sender.name }}</p>
                                  <p class="text-white-dark text-xs">
                                  {{ selectedUser.sender.last_login_status === 'Active' ? 'Active now' : 'Last seen ' + selectedUser.sender.last_login_status }}
                              </p>

                              </div>
                          </div>
                          <!-- check for owner not equal -->
                          

                      </div>
                      <div class="h-px w-full border-b border-gray-300 dark:border-gray-500"></div>
                      <div class="relative h-full sm:h-[calc(100vh_-_300px)] chat-conversation-box overflow-y-auto">
                          <div class="space-y-5 p-4 sm:pb-0 pb-[68px] sm:min-h-[300px] min-h-[400px]">
                            <!-- hr time -->
                              <!-- <div class="block m-6 mt-0">
                                  <h4 class="text-xs text-center border-b border-gray-300 dark:border-gray-400 relative">
                                      <span class="relative top-2 px-3 bg-white ">{{ 'Today, ' + selectedUser.time }}</span>
                                  </h4>
                              </div> -->
                              <!-- hr time -->
                              
                              <template v-if="selectedUser.oldest_messages && selectedUser.oldest_messages.length">
  <div v-for="message in selectedUser.oldest_messages" :key="message.id" class="flex items-start gap-3" :class="messageAlignment(message.user_id)">
    <div class="flex-none" :class="userClass(message.user_id)">
      <!-- <img :src="getAvatar(message.user_id)" class="rounded-full h-10 w-10 object-cover" /> -->

      <!-- <template v-if="isCurrentUser(message.user_id)">
  <img :src="selectedUser.receiver.img" class="rounded-full h-10 w-10 object-cover" />
</template>
<template v-else>
  <img :src="selectedUser.sender.img" class="rounded-full h-10 w-10 object-cover" />
</template> -->

      <!-- <template v-if="isCurrentUser(message.user_id)">
        <img :src="selectedUser.sender.img" class="rounded-full h-10 w-10 object-cover" />
      </template>
      <template v-if="!isCurrentUser(message.user_id)">
        <img :src="selectedUser.receiver.img" class="rounded-full h-10 w-10 object-cover" />
      </template> -->
    </div>
    <div class="space-y-2">
      <div class="flex items-center gap-3">
        <div :class="['p-4 py-2 rounded-md bg-black/10', backgroundColor(message.user_id)]">
          {{ message.body }}
          <div v-if="message.body === 'image'" class="flex items-center flex-row-reverse group">
            <div v-for="image in message.images" :key="image.id" class="w-64 h-64 relative flex flex-shrink-0 max-w-xs lg:max-w-md">
              <img class="absolute shadow-md w-full h-full rounded-l-lg object-cover" :src="image.img"/>
            </div>
          </div>
        </div>
      </div>
      <div class="text-xs text-white-dark" :class="{ 'ltr:text-right rtl:text-left': isCurrentUser(message.user_id) }">
        {{ message.time || '5h ago' }}
      </div>
    </div>
  </div>
</template>

                          </div>
                        </div>
                      <div class="p-4 absolute bottom-0 left-0 w-full">
                         <!-- Image Previews -->
                         <form @submit.prevent="upload" >
                            
                            <input type="file" ref="fileInput" @change="addImage" class="hidden" multiple />
                                <div v-if="imagePreviews.length > 0" class="mb-2 top-0 left-0 flex space-x-2">
                                <div v-for="(preview, index) in imagePreviews" :key="index" class="relative w-10 h-10">
                                <img :src="preview" class="rounded-full" />
                                <button class="absolute top-0 right-0 w-4 h-4 bg-red-500 text-white font-medium rounded-full text-xs text-center" @click="removeImage(index)">x</button>
                                </div>
                                <div>
                                <button type="submit" class="ml-4 flex shrink-0 rounded-md border border-blue-600 bg-blue-600 px-2 py-1 text-sm font-medium text-white transition hover:bg-transparent hover:text-blue-600 focus:outline-none focus:ring active:text-blue-500" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"> Upload <span><ArrowUpTrayIcon class="w-5 ml-1" /> </span></button>
                            </div>
                                </div>
                        
                            </form>
                            <!-- Image Previews -->
                          <div class="sm:flex w-full space-x-6 rtl:space-x-reverse items-center">
                              <div class="relative flex-1 px-4">
                                <button @click="confirmAddImages" type="button" class="absolute ltr:left-4 rtl:right-4 top-1/2 -translate-y-1/2 text-gray-700 hover:text-blue-500 px-3">
                                      <PhotoIcon class="w-6" />
                                  </button>
                                <!-- <button @click="triggerFileInput" type="button" class="absolute ltr:left-4 rtl:right-4 top-1/2 -translate-y-1/2 hover:text-blue-500 px-3">
                                      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
                                          <circle opacity="0.5" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5" />
                                          <path
                                              d="M9 16C9.85038 16.6303 10.8846 17 12 17C13.1154 17 14.1496 16.6303 15 16"
                                              stroke="currentColor"
                                              stroke-width="1.5"
                                              stroke-linecap="round"
                                          />
                                          <path
                                              d="M16 10.5C16 11.3284 15.5523 12 15 12C14.4477 12 14 11.3284 14 10.5C14 9.67157 14.4477 9 15 9C15.5523 9 16 9.67157 16 10.5Z"
                                              fill="currentColor"
                                          />
                                          <ellipse cx="9" cy="10.5" rx="1" ry="1.5" fill="currentColor" />
                                      </svg>
                                  </button> -->
                                  
                                  <!-- image upload here -->
                                  <!-- <button @click="triggerFileInput" type="button" class=" focus:outline-none mx-2 text-blue-600 hover:text-blue-700 w-6 h-6">
                <svg viewBox="0 0 20 20" class="w-6 fill-current">
                    <path d="M11,13 L8,10 L2,16 L11,16 L18,16 L13,11 L11,13 Z M0,3.99406028 C0,2.8927712 0.898212381,2 1.99079514,2 L18.0092049,2 C19.1086907,2 20,2.89451376 20,3.99406028 L20,16.0059397 C20,17.1072288 19.1017876,18 18.0092049,18 L1.99079514,18 C0.891309342,18 0,17.1054862 0,16.0059397 L0,3.99406028 Z M15,9 C16.1045695,9 17,8.1045695 17,7 C17,5.8954305 16.1045695,5 15,5 C13.8954305,5 13,5.8954305 13,7 C13,8.1045695 13.8954305,9 15,9 Z" />
                </svg>
            </button> -->
            
           
                                  <!-- image upload here -->
                                  <input
                                    class="form-input rounded-full border-0 bg-gray-200 px-12 focus:outline-none py-2 w-full text-gray-700"
                                    placeholder="Type a message"
                                    v-model="textMessage"
                                    required
                                    @keyup.enter.exact="sendMessage"
                                />

                                 
                                  <button
                                      type="button"
                                      class="absolute ltr:right-4 rtl:left-4 top-1/2 -translate-y-1/2 hover:text-blue-500 "
                                      @click="sendMessage(message)"
                                  >
                                      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
                                          <path
                                              d="M17.4975 18.4851L20.6281 9.09373C21.8764 5.34874 22.5006 3.47624 21.5122 2.48782C20.5237 1.49939 18.6511 2.12356 14.906 3.37189L5.57477 6.48218C3.49295 7.1761 2.45203 7.52305 2.13608 8.28637C2.06182 8.46577 2.01692 8.65596 2.00311 8.84963C1.94433 9.67365 2.72018 10.4495 4.27188 12.0011L4.55451 12.2837C4.80921 12.5384 4.93655 12.6658 5.03282 12.8075C5.22269 13.0871 5.33046 13.4143 5.34393 13.7519C5.35076 13.9232 5.32403 14.1013 5.27057 14.4574C5.07488 15.7612 4.97703 16.4131 5.0923 16.9147C5.32205 17.9146 6.09599 18.6995 7.09257 18.9433C7.59255 19.0656 8.24576 18.977 9.5522 18.7997L9.62363 18.79C9.99191 18.74 10.1761 18.715 10.3529 18.7257C10.6738 18.745 10.9838 18.8496 11.251 19.0285C11.3981 19.1271 11.5295 19.2585 11.7923 19.5213L12.0436 19.7725C13.5539 21.2828 14.309 22.0379 15.1101 21.9985C15.3309 21.9877 15.5479 21.9365 15.7503 21.8474C16.4844 21.5244 16.8221 20.5113 17.4975 18.4851Z"
                                              stroke="currentColor"
                                              stroke-width="1.5"
                                          />
                                          <path opacity="0.5" d="M6 18L21 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                      </svg>
                                  </button>
                              </div>
                              <div class="items-center space-x-3 rtl:space-x-reverse sm:py-0 py-3 hidden sm:block">
                                  
                                  
                                  
                                  
                              </div>
                          </div>
                      </div>
                  </div>
                  
              </template>
          </div>
      </div>
  </div>



  <!-- upload images -->
  <div class="lg:col-span-4 lg:row-end-1">
          <div class="">
           



            <!-- <PrimaryButton @click="confirmAddImages">Upload New Images</PrimaryButton> -->

            <Modal :show="confirmingAddImages" @close="closeModal">
            <form @submit.prevent="upload" class="mt-6 space-y-6">
           <!-- Images -->
           <div class=" text-center">
            <InputError class="mt-2" :message="form.errors.cover_image" />

            <InputLabel for="listingImage" />
      <main class=" ">
        <article
          aria-label="File Upload Modal"
          class="relative h-full flex flex-col bg-white  rounded-md"
          @drop="dropHandler"
          @dragover="dragOverHandler"
          @dragleave="dragLeaveHandler"
          @dragenter="dragEnterHandler"
        >
          <!-- <div
            ref="overlay"
            class="w-full h-full absolute top-0 left-0 pointer-events-none z-50 flex flex-col items-center justify-center rounded-md"
          >
          <i>
              <svg class="fill-current w-12 h-12 mb-3 text-blue-700" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path d="M19.479 10.092c-.212-3.951-3.473-7.092-7.479-7.092-4.005 0-7.267 3.141-7.479 7.092-2.57.463-4.521 2.706-4.521 5.408 0 3.037 2.463 5.5 5.5 5.5h13c3.037 0 5.5-2.463 5.5-5.5 0-2.702-1.951-4.945-4.521-5.408zm-7.479-1.092l4 4h-3v4h-2v-4h-3l4-4z" />
              </svg>
            </i>
            <p class="text-lg text-blue-700">Drop files to upload</p>
          </div> -->
          <section class="h-full overflow-auto p-8 w-full flex flex-col">
            <header
              class="border-dashed border-2 border-gray-400 py-12 flex flex-col justify-center items-center"
            >
            

              <div class="flex text-sm text-gray-600">
                  <label for="file-upload" class="relative cursor-pointer rounded-md bg-white font-medium text-blue-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-blue-500 focus-within:ring-offset-2 hover:text-blue-500">
                    <span>Upload Images</span>
                    <input id="file-upload" name="file-upload" type="file" class="sr-only"  accept="image/*"
                    @change="hiddenInputChange"
                @input="addImage" multiple/>
                  </label>
                  <p class="pl-1">or drag and drop</p>
                </div>
                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB each</p>

            </header>
  
            
            <h1 class="pt-8 pb-3 font-semibold sm:text-lg text-gray-900">
              To Upload
            </h1>
  
            <ul
    ref="gallery"
    id="gallery"
    class="flex flex-1 flex-wrap -m-1"
    @click="onGalleryClick"
  >
    <li
      ref="empty"
      class="h-full w-full text-center flex flex-col justify-center items-center"
    >
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-32 h-32">
  <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
</svg>

      <span class="text-small text-gray-500">No image selected</span>
    </li>
  </ul>
          </section>
        </article>
        <InputError class="mt-2" :message="form.errors.image" />
      </main>
    </div>

            <!-- Images -->

           


          

            <div class="text-center  mb-2">
              <div class=" text-center mb-2">
                <PrimaryButton :disabled="form.processing">Upload</PrimaryButton>

                <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition duration-5000 ease-in-out">
                    <h1 v-if="form.recentlySuccessful" class="text-sm text-gray-600">Images Uploaded.</h1>
                </Transition>
              </div>
            </div>
        </form>

      </Modal>



          </div>
        </div>
  <!-- upload images -->
</template>
<script setup>
  import { ref, computed,reactive,onMounted, onUnmounted } from 'vue';
  import { router,usePage,useForm } from '@inertiajs/vue3';
  import { MagnifyingGlassCircleIcon, MagnifyingGlassIcon,PhotoIcon,ArrowUpTrayIcon } from '@heroicons/vue/20/solid';

import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import Modal from '@/Components/Modal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

import axios from 'axios';
 
const props = defineProps({
        'chats': [Object,Array],
    })

   

    const page = usePage()

  const isShowUserChat = ref(false);
  const isShowChatMenu = ref(false);


  const searchUser = ref('');
  const textMessage = ref('');
  const selectedUser = ref(null);
  const fileInput = ref(null);

  const searchUsers = computed(() => {
    return props.chats.filter(chat =>
        chat.owner && (
            chat.owner.name.toLowerCase().includes(searchUser.value.toLowerCase()) ||
            chat.sender.name.toLowerCase().includes(searchUser.value.toLowerCase()) ||
            chat.receiver.name.toLowerCase().includes(searchUser.value.toLowerCase())
        )
    );
});

const notificationCount = computed(
  () => page.props.auth.notificationCount
)

const clearNoti = () => {
  if (notificationCount.value === 0) {
    return;
  }
   // clear noti
   router.post(
        route('markas.read.all'),
        {
          preserveState: false,
          preserveScroll: true,
          onSuccess: () => {
            console.log('cleared noti.')
          },
        }
      );

};

  const selectUser = user => {
      selectedUser.value = user;
      isShowUserChat.value = true;
      scrollToBottom();
      isShowChatMenu.value = false;

      clearNoti();
  };


  const toUser = computed(() => {
    if(selectedUser.value.user1_id != page.props.auth.user.id && selectedUser.value.user2_id == page.props.auth.user.id ){
        return selectedUser.value.user1_id
    } else{
        return selectedUser.value.user2_id
    }
});



const confirmingAddImages = ref(false);
const confirmAddImages = () => {
  confirmingAddImages.value = true;
};

const closeModal = () => {
  confirmingAddImages.value = false;
};



const FILES = reactive({});
  
  const gallery = ref(null);
  const hiddenInput = ref(null);
  const overlay = ref(null);
  const empty = ref(null);
  
  const addFile = (target, file) => {
    const isImage = file.type.match('image.*');
    const objectURL = URL.createObjectURL(file);
  
    const li = document.createElement('li');
    li.classList.add(
      'block',
      'p-1',
      'w-1/2',
      'sm:w-1/3',
      'md:w-1/4',
      'lg:w-1/6',
      'xl:w-1/8',
      'h-24'
    );
  
    const article = document.createElement('article');
    article.setAttribute('tabindex', '0');
    article.classList.add(
    'group',
    'w-full',
    'h-full',
    'rounded-md',
    'focus:outline-none',
    'focus:shadow-outline',
    'blue'
  );
  li.appendChild(article);

  const img = document.createElement('img');
  img.setAttribute('alt', file.name);
  img.setAttribute('src', objectURL);
  img.classList.add(
    'w-full',
    'h-full',
    'object-cover',
    'rounded-md',
    'shadow-md',
    'hover:shadow-lg'
  );
  article.appendChild(img);

  if (isImage) {
    article.appendChild(img);
  } else {
    // Add any additional logic for non-image files
  }
  

  const imgWrapper = document.createElement('div');
  imgWrapper.classList.add('relative');
  article.appendChild(imgWrapper);

  imgWrapper.appendChild(img);

  const deleteIcon = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
  deleteIcon.classList.add(
    'absolute',
    'top-0',
    'right-0',
    'w-6',
    'h-6',
    'mt-1',
    'mr-1',
    'cursor-pointer',
    'text-red-500',
    'hover:text-red-600'
  );
  deleteIcon.setAttribute('viewBox', '0 0 24 24');
  deleteIcon.innerHTML = `
    <path fill="currentColor" d="M3 6l3 18h12l3-18h-18zm19-4v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.316c0 .901.73 2 1.631 2h5.711z" />
  `;
  imgWrapper.appendChild(deleteIcon);

  deleteIcon.addEventListener('click', (event) => {
    event.stopPropagation();
    delete FILES[file.name];
    target.removeChild(li);
    if (Object.keys(FILES).length === 0) {
      empty.value.style.display = 'block';
    }
  });

  target.appendChild(li);
};

const triggerInput = () => {
  hiddenInput.value.click();
};

const hiddenInputChange = (event) => {
  const files = event.target.files;

  for (const file of files) {
    addFile(gallery.value, file);
    FILES[file.name] = file;
  }

  empty.value.style.display = 'none';
};

const dragOverHandler = (event) => {
  event.preventDefault();
  overlay.value.style.visibility = 'visible';
  overlay.value.style.opacity = '1';
};

const dragLeaveHandler = (event) => {
  event.preventDefault();
  overlay.value.style.visibility = 'hidden';
  overlay.value.style.opacity = '0';
};

const dragEnterHandler = (event) => {
  event.preventDefault();
};

const dropHandler = (event) => {
  event.preventDefault();
  const files = event.dataTransfer.files;

  for (const file of files) {
    addFile(gallery.value, file);
    FILES[file.name] = file;
  }

  empty.value.style.display = 'none';
  overlay.value.style.visibility = 'hidden';
  overlay.value.style.opacity = '0';
};

const onGalleryClick = (event) => {
  if (event.target.closest('li') !== empty.value) {
    console.log('You clicked on an item:', event.target.closest('li'));
  }
};


const form = useForm({
    owner_type: '',
    owner: '',
    to_user_id: '',
    message: '',
    image: '',
    chat_id: '',
    listing_id: '',
});

const imagePreviews = ref([]);

const addImage = (event) => {
    form.image = event.target.files;
    form.message = 'image';
    form.to_user_id = toUser.value;
    form.owner = selectedUser.value.owner.user_id;
    form.owner_type = selectedUser.value.owner_type;
    form.chat_id = selectedUser.value.id;
    form.listing_id = selectedUser.value.listing?.id;

    const files = event.target.files;

    Array.from(files).forEach(file => {
        const reader = new FileReader();
        reader.onload = (e) => {
            selectedUser.value.oldest_messages.push({
                user_id: page.props.auth.user.id,
                body: 'image',
                time: 'Just now',
                chat_id: selectedUser.value.id,
                images: [{ img: e.target.result }] // Making 'images' an array
            });
        };
        reader.readAsDataURL(file);
    });
}


// scrollToBottom();
// const addImage = (event) => {
//     form.image = event.target.files;
//     form.message = 'image';

//     form.to_user_id = toUser.value;
//     form.owner = selectedUser.value.owner.user_id;
//     form.owner_type = selectedUser.value.owner_type;
//     form.chat_id = selectedUser.value.id;

//   const files = event.target.files;

//   Array.from(files).forEach(file => {
//     const reader = new FileReader();
//     reader.onload = (e) => {
//       imagePreviews.value.push(e.target.result);
//     };
//     reader.readAsDataURL(file);
//   });
// };




const triggerFileInput = () => {
  if (fileInput.value) {
    fileInput.value.click();
  }
};




const removeImage = (index) => {
  imagePreviews.value.splice(index, 1); // remove the image at the specified index
};


const upload = () => {
  form.post(
    route('profile.create.message'),
    {
      preserveScroll: true,
      onSuccess: () => {
        
        form.reset();
        confirmingAddImages.value = false;

        

      },
    },
  )
}


// const upload = () => {
//   form.post(
//     route('profile.create.message'),
//     {
//     preserveScroll: true,
//     onSuccess: () => {
//         form.reset('message');
        
//         // Clear the image previews
//         imagePreviews.value = [];
        
//         // Clear the file input
//         fileInput.value.value = '';
//       },

      
//     },
//   )
// }

//   console.log(selectedUser)
const sendMessage = async () => {
    if (textMessage.value.trim() && selectedUser.value && Array.isArray(selectedUser.value.oldest_messages)) {
        selectedUser.value.oldest_messages.push({
            user_id: page.props.auth.user.id,
            body: textMessage.value,
            time: 'Just now',
            chat_id: selectedUser.value.id,
        });

        

        console.log(form.listing_id)
        scrollToBottom();

        // Prepare the message data for the API
        const messageData = {
            to_user_id: toUser.value,
            message: textMessage.value,
            owner: selectedUser.value.owner.user_id,
            owner_type: selectedUser.value.owner_type,
            chat_id: selectedUser.value.id,
            listing_id: selectedUser.value.listing?.id,
        };

        // console.log(messageData);

        try {
        const c = route('send.message');
        const response = await axios.post(c, messageData);
        textMessage.value = '';
        scrollToBottom();
        return response.data;
        } catch (error) {
            console.error('Error sending message:', error);
            textMessage.value = '';
            scrollToBottom();
        }

        // Clear the input field and scroll to bottom
        textMessage.value = '';
        scrollToBottom();
    }
};




  const scrollToBottom = () => {
      if (isShowUserChat.value) {
          setTimeout(() => {
              const element = document.querySelector('.chat-conversation-box');
              if (element) {
                element.behavior = 'smooth';
                element.scrollTop = element.scrollHeight;
              }
          }, 0);
      }
  };


   // refresh the page
   const fetchChatData = () => {
  router.reload(
    {
      // method: 'get',
      preserveState: false,
      preserveScroll: true,
      onSuccess: () => {
        console.log('Page load was successful.')
      },
    }
  );

};

   

let intervalId;

// onMounted(() => {
//   fetchChatData(); // Initial fetch
//   intervalId = setInterval(fetchChatData, 60000); // Fetch every 60 seconds
// });

setInterval(fetchChatData, 60000);

onUnmounted(() => {
  clearInterval(intervalId); // Clear the interval when the component is unmounted
});



const isCurrentUser = (userId) => {
  const result = userId == page.props.auth.user.id;
  // console.log(`Is Current User: ${result} for user ID ${userId} current user ${page.props.auth.user.id}`);
  return result;
}

const userClass = (userId) => {
  const cls = isCurrentUser(userId) ? 'order-2' : '';
  // console.log(`User class for ${userId}: ${cls} - current user ${page.props.auth.user.id}`);
  return cls;
}

const messageAlignment = (userId) => {
  const align = isCurrentUser(userId) ? 'justify-end' : '';
  // console.log(`Message alignment for ${userId}: ${align} - current user ${page.props.auth.user.id}`);
  return align;
}

const backgroundColor = (userId) => {
  const color = isCurrentUser(userId) ? '!bg-blue-500 text-white' : 'dark:bg-gray-400';
  // console.log(`Background color for ${userId}: ${color} - current user ${page.props.auth.user.id}`);
  return color;
}

const getAvatar = (userId) => {
  // If the message is sent by the current user, use their avatar.
  // Otherwise, use the other party’s avatar.
  return isCurrentUser(userId)
    ? page.props.auth.user.img // or selectedUser.sender.img, if that's the correct one for the current user
    : selectedUser.value.receiver.img;
};


</script>