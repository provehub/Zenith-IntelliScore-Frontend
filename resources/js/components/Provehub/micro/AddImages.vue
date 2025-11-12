<script setup>
import { useForm} from '@inertiajs/vue3';
import { ref, reactive } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
  'gym': Object,
})
 


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
    image: [],
});

const addImage = (event) => {
  for (const imgs of event.target.files) {
    form.image.push(imgs)
  }
}


const upload = () => {
  form.post(
    route('gym.media.images', {gym: props.gym.slug}),
    {
      preserveScroll: true,
      onSuccess: () => {
        // form.reset();

        console.log('FILES before deletion:', FILES);  // Check the FILES object before deletion

        // Iterate over all files and remove each one
        for (const fileName in FILES) {
          delete FILES[fileName];
          const li = document.getElementById(fileName);
          if (li) {
            li.parentNode.removeChild(li);
          } else {
            console.log('Could not find li element with id:', fileName);  // Log if li element cannot be found
          }
        }

        console.log('FILES after deletion:', FILES);  // Check the FILES object after deletion

        // Show the empty value style if no files remain
        if (Object.keys(FILES).length === 0) {
          empty.style.display = 'block';
        }
      },
    },
  )
}



  
</script>

<template>

   
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:max-w-7xl lg:px-8">
          <h1 class="sr-only">Profile</h1>
          <!-- Main 3 column grid -->
          <div class="grid grid-cols-1 items-start gap-4  lg:gap-8">
            <!-- Left column -->
            <div class="grid grid-cols-1 gap-4 lg:col-span-2">
              <!-- Welcome panel -->
              <section aria-labelledby="profile-overview-title">
                <div class="overflow-hidden rounded-lg bg-white shadow">
                  
                  

                  <ul role="list" class="divide-y">
      <li class="px-2 py-2">
        <!-- Your content -->
        <div class="lg:col-span-4 lg:row-end-1">
          <div class="">
           




            <form @submit.prevent="upload" class="mt-6 space-y-6">
           <!-- Images -->
           <div class=" ">
            <InputError class="mt-2" :message="form.errors.cover_image" />

            <InputLabel for="listingImage" value="Listing Images" />
      <main class=" ">
        <article
          aria-label="File Upload Modal"
          class="relative h-full flex flex-col bg-white  rounded-md"
          @drop="dropHandler"
          @dragover="dragOverHandler"
          @dragleave="dragLeaveHandler"
          @dragenter="dragEnterHandler"
        >
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
            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Upload</PrimaryButton>

                <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition duration-5000 ease-in-out">
                    <h1 v-if="form.recentlySuccessful" class="text-sm text-gray-600">Images Uploaded.</h1>
                </Transition>
            </div>
        </form>

          </div>
        </div>


       
      </li>
     
    </ul>



                </div>
              </section>
  
              
            </div>
  
            <!-- Right column -->
            
          </div>
        </div>
</template>

