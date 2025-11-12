<template>
  <div class="bg-gray-50">
    <div class="text-center">
            <h2 class="text-2xl py-8 font-bold tracking-tight text-gray-900">How It Works</h2>
          </div>
    <div class="mx-auto max-w-7xl py-4 sm:px-2 sm:py-4 lg:px-4">
      <div class="mx-auto grid max-w-2xl grid-cols-1 gap-x-8 gap-y-12 px-4 lg:max-w-none lg:grid-cols-2 lg:gap-y-16">
        <div v-for="perk in perks" :key="perk.name" class="sm:flex">
          <div class="sm:flex-shrink-0">
            <div class="flow-root">
              <img class="h-24 w-28" :src="perk.imageSrc" alt="" />
            </div>
          </div>
          <div class="mt-3 sm:ml-3 sm:mt-0">
            <h3 class="text-sm font-medium text-gray-900">{{ perk.name }}</h3>
            <p class="mt-2 text-sm text-gray-500">{{ perk.description }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const perks = [
  {
    name: 'Donate N100/$0.07 daily',
    imageSrc: 'https://provehub.com/cdn/clients/tail/icon-gift-card-light.svg',
    description:
      "A small amount that, when multiplied, changes lives.",
  },
  {
    name: 'The daily amount raised is divided by N5,000 per person',
    imageSrc: 'https://provehub.com/cdn/clients/tail/icon-warranty-light.svg',
    description:
      "This determines how many people we feed the following day.",
  },
  {
    name: 'Real-time updates',
    imageSrc: 'https://provehub.com/cdn/clients/tail/icon-returns-light.svg',
    description:
      'Our website tracks donations, showing the number of contributors and beneficiaries daily.',
  },
  {
    name: 'Video proof of impact',
    imageSrc: 'https://provehub.com/cdn/clients/tail/icon-planet-light.svg',
    description:
      "Meal distributions are recorded, creating accountability and trust.",
  },
]
</script>