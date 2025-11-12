<script setup>
import { Checkbox } from '@/components/ui/checkbox';
import InputError from '@/Components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Input } from '@/components/ui/input';
import { Head, Link, useForm,usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import Favicon from '@/Components/Favicon.vue';
import ApplicationLogoWhite from '@/Components/ApplicationLogoWhite.vue';
import { LoaderCircle } from 'lucide-vue-next';
import { route } from 'ziggy-js'  


defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

const page = usePage()
const flashSuccess = computed(
() => page.props.flash.success,
)
const flashError = computed(
() => page.props.flash.error,
)

</script>

<template>
        <Head title="Log In" />
        <Favicon />
        <section class="1212">
  <div class="lg:grid lg:min-h-screen lg:grid-cols-12">
    <section
      class="relative flex h-32 items-end bg-gray-900 lg:col-span-6 lg:h-full xl:col-span-6"
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
          Welcome Back!
        </h2>

        <p class="mt-4 text-2xl leading-relaxed text-white/90">
            Login to continue Zenith IntelliScore. 
        </p>
      </div>
    </section>

    <main aria-label="Main"
      class="flex items-center justify-center px-8 py-8 sm:px-12 lg:col-span-7 lg:px-16 lg:py-12 xl:col-span-6">
      <div class="max-w-xl lg:max-w-4xl">
        <div class="relative -mt-16 block lg:hidden">
          <Link class="inline-flex h-16 w-16 items-center justify-center rounded-full bg-white text-red-600 sm:h-20 sm:w-20"
            href="/">
            <span class="sr-only">Home</span>
            <ApplicationLogoWhite class="h-8 w-auto" alt="Zenith IntelliScore" />
          </Link>

          <h1
            class="mt-2 text-2xl font-bold sm:text-3xl md:text-4xl"
          >
          Welcome Back!
          </h1>

          <p class="mt-4 text-2xl leading-relaxed">
            Login to continue Zenith IntelliScore.
        </p>
        </div>

        <div v-if="status" class="mb-4 font-medium text-sm text-red-600">
            {{ status }}
        </div>

        <!-- alert -->
<div class="flex justify-center mt-4">
<span v-if="flashSuccess"
                            class="inline-flex items-center justify-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-emerald-700">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                class="-ml-1 mr-1.5 h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>

                            <p class="whitespace-nowrap text-sm">{{ flashSuccess }}</p>
                        </span>
                        <span v-if="flashError"
                            class="inline-flex items-center justify-center rounded-full bg-red-100 px-2.5 py-0.5 text-red-700">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                class="-ml-1 mr-1.5 h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>

                            <p class="whitespace-nowrap text-sm">{{ flashError }}</p>
                        </span>
                        </div>
                        <!-- alert -->

        <div class="flex items-center justify-between mt-4">
            <span class="w-1/5 border-b lg:w-1/4 "></span>

            <a href="#" class="text-md text-center text-gray-500 uppercase dark:text-gray-100">Login</a>

            <span class="w-1/5 border-b lg:w-1/4"></span>
        </div>



        <form @submit.prevent="submit" class="mt-8 grid grid-cols-6 gap-6">
          

          

          <div class="col-span-6">
            <label
              class="block text-sm font-medium text-gray-700 dark:text-gray-200"
            >Email address</label>
                    <Input
                        id="email"
                        type="email"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="email"
                        v-model="form.email"
                        placeholder="email@example.com"
                    />
                    <InputError :message="form.errors.email" />
          </div>

          <div class="col-span-6">
            <div class="flex items-center justify-between">
              <label
              class="block text-sm font-medium text-gray-700 dark:text-gray-200"
            >Password</label>
                        <TextLink v-if="canResetPassword" :href="route('password.request')" class="text-sm" :tabindex="5">
                            Forgot password?
                        </TextLink>
                    </div>
                    <Input
                        id="password"
                        type="password"
                        required
                        :tabindex="2"
                        autocomplete="current-password"
                        v-model="form.password"
                        placeholder="Password"
                    />
                    <InputError :message="form.errors.password" />
          </div>

          

          <!-- <div class="flex items-center justify-between" :tabindex="3">
                    <Label for="remember" class="flex items-center space-x-3">
                        <Checkbox id="remember" v-model:checked="form.remember" :tabindex="4" />
                        <span>Remember me</span>
                    </Label>
                </div>

                <Button type="submit" class="mt-4 w-full" :tabindex="4" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Log in
                </Button> -->

          <div class="block mt-3 col-span-6">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-200">Remember me</span>
                </label>
            </div>

          

          <div class="col-span-6">
            <p class="text-sm text-gray-500 dark:text-gray-200">
              By using Zenith IntelliScore, you agree to our
              <Link href="#" class="text-gray-700 underline dark:text-gray-200">
                terms and conditions
              </Link>
              and
              <Link href="#" class="text-gray-700 dark:text-gray-200 underline">privacy policy</Link>.
            </p>
          </div>

          <div class="col-span-6 sm:flex sm:items-center sm:gap-4">
            <button
              class="flex shrink-0 rounded-md border border-red-600 bg-red-600 px-12 py-3 text-sm font-medium text-white transition hover:bg-transparent hover:text-red-600 focus:outline-none focus:ring active:text-red-500" :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing">
              <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
              Login
            </button>

            <p class="mt-4 text-sm text-gray-500 sm:mt-0">
              <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:text-gray-200"
                >
                    Forgot your password?
                </Link>
            </p>

            <p class="mt-4 text-sm text-gray-500 sm:mt-0 dark:text-gray-200">
              Don't have an account?
              <Link :href="route('register')" class="text-gray-700 underline dark:text-gray-200">Register</Link>.
            </p>

          </div>
        </form>
      </div>
    </main>
  </div>
</section>



</template>
