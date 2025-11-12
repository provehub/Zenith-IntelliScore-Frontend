<script setup>
    import AppLayout from '@/layouts/AppLayout.vue';
    import {
        Head,
        usePage
    } from '@inertiajs/vue3';
    import {
        computed,
        watchEffect,
        ref
    } from 'vue';

    import {
        ChevronRightIcon,
    } from '@heroicons/vue/20/solid'

    import ChatsAll from '@/Components/Provehub/ChatsAll.vue';

    const props = defineProps({
        'chats': [Object,Array],
    })

    const user = usePage().props.auth.user;

    const page = usePage()

    const flashSuccess = ref(page.props.flash.success)
    const flashError = ref(page.props.flash.error)

    const showSuccessMessage = ref(!!flashSuccess.value)
    const showErrorMessage = ref(!!flashError.value)

    watchEffect(() => {
        flashSuccess.value = page.props.flash.success
        flashError.value = page.props.flash.error
        showSuccessMessage.value = !!flashSuccess.value
        showErrorMessage.value = !!flashError.value
        if (flashSuccess.value) {
            setTimeout(() => {
                showSuccessMessage.value = false
            }, 5000)
        }
        if (flashError.value) {
            setTimeout(() => {
                showErrorMessage.value = false
            }, 5000)
        }
    })


    const profileImageUrl = computed(() => {
        return route('index') + '/storage/profiles/' + user.profile_image;
    });

    const greeting = computed(() => {
        let hour = parseInt(props.time.substring(0, 2));
        if (hour < 12) {
            return 'Welcome back';
        } else if (hour < 18) {
            return 'Welcome back';
        } else {
            return 'Welcome back';
        }
    });

    
    const breadcrumbs = ref([
    {
        title: 'Messages',
        href: '/chat',
    },
]);

</script>

<template>

    <Head title="Chats" />

    <AppLayout :breadcrumbs="breadcrumbs">
        
        <div class="">
            <div class="">
                <div class="">
<!-- start -->
<div class="">
    <div class="py-1 sm:py-1">
      <!-- <div class="mx-auto max-w-7xl sm:px-1 lg:px-8">
        <div class="">
          <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">Messages</h1>
          <p class="mt-2 text-sm text-gray-500">Send and reply all your messages.</p>
        </div>
      </div> -->

      <div class="">     
        <ChatsAll :chats="props.chats" />
      </div>

    </div>
  </div>
<!-- start -->
      </div>
      </div>
      </div>


        <!-- Page header -->
                      

        
    </AppLayout>
</template>
