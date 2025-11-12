 <template>
   <!-- CTA section -->
    <div class="bg-white dark:bg-white">
   <img src="/images/city.svg"/>
    </div>
   <section aria-labelledby="sale-heading">
          <div class="overflow-hidden">
            <div class="bg-black">
              <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="relative pt-48 pb-16 sm:pb-24">
                  <div>
                    <h2 id="sale-heading" class="text-4xl font-bold tracking-tight text-white md:text-5xl">
                      Every find 
                      <br />
                      is progress.
                    </h2>

                    <div class="mt-6 text-base">
                      <Link :href="route('register')"  class="font-semibold text-white">
                        Get Started
                        <span aria-hidden="true"> &rarr;</span>
                      </Link>
                    </div>
                  </div>
  
                  <div class="absolute -top-32 left-1/2 -translate-x-1/2 transform sm:top-6 sm:translate-x-0">
                    <div class="ml-24 flex min-w-max space-x-6 sm:ml-3 lg:space-x-8">
                      <div class="flex space-x-6 sm:flex-col sm:space-x-0 sm:space-y-6 lg:space-y-8">
                        <div class="flex-shrink-0">
                          <img class="h-64 w-64 rounded-lg object-cover md:h-72 md:w-72" :src="$page.props.site.img_share.eight" alt="">
                        </div>
  
                        <div class="mt-6 flex-shrink-0 sm:mt-0">
                          <img class="h-64 w-64 rounded-lg object-cover md:h-72 md:w-72" :src="$page.props.site.img_share.sixteen" alt="" />
                        </div>
                      </div>
                      <div class="flex space-x-6 sm:-mt-20 sm:flex-col sm:space-x-0 sm:space-y-6 lg:space-y-8">
                        <div class="flex-shrink-0">
                          <img class="h-64 w-64 rounded-lg object-cover md:h-72 md:w-72" :src="$page.props.site.img_share.thirteen" alt="" />
                        </div>
  
                        <div class="mt-6 flex-shrink-0 sm:mt-0">
                          <img class="h-64 w-64 rounded-lg object-cover md:h-72 md:w-72" :src="$page.props.site.img_share.seventeen" alt="" />
                        </div>
                      </div>
                      <div class="flex space-x-6 sm:flex-col sm:space-x-0 sm:space-y-6 lg:space-y-8">
                        <div class="flex-shrink-0">
                          <img class="h-64 w-64 rounded-lg object-cover md:h-72 md:w-72" :src="$page.props.site.img_share.fourteen" alt="" />
                        </div>
  
                        <div class="mt-6 flex-shrink-0 sm:mt-0">
                          <img class="h-64 w-64 rounded-lg object-cover md:h-72 md:w-72" :src="$page.props.site.img_share.eight" alt="" />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>
