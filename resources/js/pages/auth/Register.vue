<script setup>
import InputError from '@/components/InputError.vue';
import { Input } from '@/components/ui/input';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

import ApplicationLogoWhite from '@/Components/ApplicationLogoWhite.vue';
import ApplicationIcon from '@/Components/ApplicationIcon.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
     <Head title="Register" />
    <section class="">
  <div class="lg:grid lg:min-h-screen lg:grid-cols-12">
    <section
      class="relative flex h-32 items-end bg-gray-900 lg:col-span-5 lg:h-full xl:col-span-6"
    >
      <img
      alt="Zenith IntelliScore" src="https://images.unsplash.com/photo-1709534486708-fb8f94150d0a?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=687"
        class="absolute inset-0 h-full w-full object-cover opacity-80"
      />

      <div class="hidden lg:relative lg:block lg:p-12">
        <Link class="block text-white" href="/">
          <span class="sr-only">Home</span>
          <ApplicationLogoWhite class="h-8 w-auto" alt="Zenith IntelliScore" />
        </Link>

        <h2 class="mt-6 text-2xl font-bold text-white sm:text-3xl md:text-4xl">
          Join Zenith IntelliScore
        </h2>

        <p class="mt-4 leading-relaxed text-white/90">
            Register to Harness the power of Zenith IntelliScore to get your credit score.
        </p>
      </div>
    </section>

    <main
      aria-label="Main"
      class="flex items-center justify-center px-8 py-8 sm:px-12 lg:col-span-7 lg:px-16 lg:py-12 xl:col-span-6"
    >
      <div class="max-w-xl lg:max-w-3xl">
        <div class="relative -mt-16 block lg:hidden">
          <Link
            class="inline-flex h-16 w-16 items-center justify-center rounded-full bg-white text-red-600 sm:h-20 sm:w-20"
            href="/"
          >
            <span class="sr-only">Home</span>
            <ApplicationIcon class="h-8 w-auto" alt="Zenith IntelliScore" />
          </Link>

          <h1
            class="mt-2 text-2xl font-bold text-gray-900 dark:text-gray-200 sm:text-3xl md:text-4xl"
          >
          Join Zenith IntelliScore
          </h1>

          <p class="mt-4 leading-relaxed text-gray-500 dark:text-gray-200">
            Register to Harness the power of Zenith IntelliScore to accelerate your next big idea.
          </p>
        </div>

        <div class="flex items-center justify-between mt-4">
            <span class="w-1/5 border-b  lg:w-1/4"></span>

            <a href="#" class="text-md text-center text-gray-500 uppercase dark:text-gray-100 ">Sign up</a>

            <span class="w-1/5 border-b  lg:w-1/4"></span>
        </div>

        <form @submit.prevent="submit" class="mt-8 grid grid-cols-6 gap-6">
          <div class="col-span-6">
            <label
              class="block text-sm font-medium text-gray-700 dark:text-gray-200"
            >
              Full Name
            </label>

            <Input id="name" type="text" required autofocus :tabindex="1" autocomplete="name" v-model="form.name" placeholder="Full name" />
                    <InputError :message="form.errors.name" />
                    
          </div>

          <div class="col-span-6">
            <label for="Email" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
              Email
            </label>

            <Input id="email" type="email" required :tabindex="2" autocomplete="email" v-model="form.email" placeholder="email@example.com" />
                    <InputError :message="form.errors.email" />
          </div>

          <div class="col-span-6 sm:col-span-3 ">
            <label
              for="Password"
              class="block text-sm font-medium text-gray-700 dark:text-gray-200"
            >
              Password <i> (8 characters minimum)</i>
            </label>

            <Input
                        id="password"
                        type="password"
                        required
                        :tabindex="3"
                        autocomplete="new-password"
                        v-model="form.password"
                        placeholder="Password"
                    />
                    <InputError :message="form.errors.password" />
          </div>

          <div class="col-span-6 sm:col-span-3">
            <label
              for="PasswordConfirmation"
              class="block text-sm font-medium text-gray-700 dark:text-gray-200"
            >
              Password Confirmation <i> (8 characters minimum)</i>
            </label>

            <Input
                        id="password_confirmation"
                        type="password"
                        required
                        :tabindex="4"
                        autocomplete="new-password"
                        v-model="form.password_confirmation"
                        placeholder="Confirm password"
                    />
                    <InputError :message="form.errors.password_confirmation" />
          </div>

          <div class="col-span-6">
            <label for="MarketingAccept" class="flex gap-4">
              <input
                type="checkbox"
                id="MarketingAccept"
                name="marketing_accept"
                class="h-5 w-5 rounded-md border-gray-200 bg-white shadow-sm"
              />

              <span class="text-sm text-gray-700 dark:text-gray-200">
                I want to receive emails about events, updates and announcements.
              </span>
            </label>
          </div>

          <div class="col-span-6">
            <p class="text-sm text-gray-500 dark:text-gray-300">
              By creating an account, you agree to our
              <a href="#" class="text-gray-700 underline dark:text-gray-300">
                terms and conditions
              </a>
              and
              <a href="#" class="text-gray-700 underline dark:text-gray-300">privacy policy</a>.
            </p>
          </div>

          <div class="col-span-6 sm:flex sm:items-center sm:gap-4">
            <button
              class="flex shrink-0 rounded-md border border-red-600 bg-red-600 px-12 py-3 text-sm font-medium text-white transition hover:bg-transparent hover:text-red-600 focus:outline-none focus:ring active:text-red-500" :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing">
              <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
              Create an account
            </button>

            <p class="mt-4 text-sm text-gray-500 sm:mt-0 dark:text-gray-200">
              Already have an account?
              <Link :href="route('login')" class="text-gray-700 underline dark:text-gray-200">Log in</Link>.
            </p>
          </div>
        </form>
      </div>
    </main>
  </div>
</section>

</template>
