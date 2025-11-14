<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import countryData from '@/Custom/countries.js';
import vSelect from 'vue-select';
import { useForm, } from '@inertiajs/vue3';
import { watch,ref,onMounted } from 'vue';

const props = defineProps({
  settings: Array,
  country: {Array,Object},
})

const form = useForm({
  name: '',
  email: '',
  seo: '',
  base_country: '',
  logo_dark: '',
  logo_white: '',
  favicon: '',
  entrance_fee: '',
  sett: 'site_info',
})

const addFavicon = (event) => {
    form.favicon = event.target.files;
}
const addLogoDark = (event) => {
    form.logo_dark = event.target.files;
}
const addLogoWhite = (event) => {
    form.logo_white = event.target.files;
}

const countryOptions = ref(countryData);

let loadingCountry = false;

onMounted(async () => {
  try {
    loadingCountry = true;
          form.base_country = props.country;
      } catch (error) {
        // handle error
      }finally {
        loadingCountry = false;
      }
    });

// const ccc = props.settings && props.settings.find(setting => setting.field === 'base_country').value

let formValues = {
  name: props.settings && props.settings.find(setting => setting.field === 'site_name').value,
  email: props.settings && props.settings.find(setting => setting.field === 'site_email').value,
  seo: props.settings && props.settings.find(setting => setting.field === 'seo').value,
  entrance_fee: props.settings && props.settings.find(setting => setting.field === 'entrance_fee').value,
}

watch(formValues, (newValue) => {
  form.name = newValue.name
  form.email = newValue.email
  form.seo = newValue.seo
  form.entrance_fee = newValue.entrance_fee
})

const upload = () => {
  form.name = formValues.name
  form.email = formValues.email
  form.seo = formValues.seo
  form.entrance_fee = formValues.entrance_fee
  form.post(
    route('admin.update.settings'),
    {
    preserveScroll: true,
      onSuccess: () => form.reset(),
    },
  )
}

// Watch for changes in form.recentlySuccessful
watch(() => form.recentlySuccessful, (newValue) => {
    if (newValue) {
        // Perform a hard refresh
        window.location.reload();
    }
});

</script>

<style>
@import "vue-select/dist/vue-select.css";
</style>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Zenith IntelliScore Site Settings</h2>
            <p class="mt-1 text-sm text-gray-600">
                Manage and update your site settings
            </p>
        </header>

        <form @submit.prevent="upload" class="mt-6 space-y-6">
            <div>
                <InputLabel for="name" value="Site Name" />
                <TextInput
                    id="name"
                    name="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="formValues.name"
                    required
                    autofocus
                    autocomplete="name"
                />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="email" value="Site Support Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="formValues.email"
                    required
                    autocomplete="email"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
                <InputLabel for="description" value="SEO Meta Content" />
                <TextInput
                    id="seo"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="formValues.seo"
                    required
                    autocomplete="seo"
                />
                <InputError class="mt-2" :message="form.errors.seo" />
            </div>

            <div>
                <InputLabel for="entrance_fee" value="Academic Session" />
                <TextInput
                    id="entrance_fee"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="formValues.entrance_fee"
                    required
                    autocomplete="entrance_fee"
                />
                <InputError class="mt-2" :message="form.errors.entrance_fee" />
            </div>

            <div>
                <InputLabel for="Logo" value="Logo Dark" />
                <TextInput @input="addLogoDark"
                    type="file"
                    class="mt-1 block w-full"
                />
                <InputError class="mt-2" :message="form.errors.logo_dark" />
            </div>

            <div>
                <InputLabel for="Logo" value="Logo White" />
                <TextInput @input="addLogoWhite"
                    type="file"
                    class="mt-1 block w-full"
                />
                <InputError class="mt-2" :message="form.errors.logo_white" />
            </div>

            <div>
                <InputLabel for="Favicon" value="Favicon" />
                <TextInput @input="addFavicon"
                    type="file"
                    class="mt-1 block w-full"
                />
                <InputError class="mt-2" :message="form.errors.favicon" />
            </div>

            <div class="mb-4">
                <v-select
                v-model="form.base_country"
                :options="countryOptions"
                label="name"
                :filterable="true"
                placeholder="Select a country"
                />
                <InputError class="mt-2" :message="form.errors.base_country" />
                </div>

            <input type="hidden" v-model="sett">

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition duration-1000 ease-in-out">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Settings Updated.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
