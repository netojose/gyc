<section class="bg-[#f4f3f0] text-[#2d1b33] py-16 px-6 md:px-12 lg:px-24 font-sans" x-data="{ currentTab: 1 }">
    <div class="max-w-6xl mx-auto">

        <!-- Header -->
        <div class="mb-12">
            <div class="font-anton uppercase flex items-center gap-3 text-xs font-semibold tracking-widest text-gray-500 mb-4">
                <span class="w-8 h-px bg-gray-400"></span> Program
            </div>
            <h2 class="font-jakarta text-5xl md:text-6xl font-normal tracking-tight leading-tight">
                Three days.<br>One purpose.
            </h2>
        </div>

        <!-- Tabs Navigation -->
        <div class="border-b border-gray-300 mb-10">
            <div class="flex flex-wrap gap-8 md:gap-12 text-xs font-bold tracking-widest uppercase">
                <!-- Active Tab -->
                <button class="font-jakarta cursor-pointer transition" :class="{ 'border-b-2 border-[#2d1b33] pb-4 text-[#2d1b33]': currentTab === 1, 'text-gray-400 pb-4 hover:text-[#2d1b33]': currentTab !== 1 }" @click="currentTab = 1">
                    Thursday · Dec 26
                </button>
                <!-- Inactive Tabs -->
                <button class="font-jakarta cursor-pointer transition" :class="{ 'border-b-2 border-[#2d1b33] pb-4 text-[#2d1b33]': currentTab === 2, 'text-gray-400 pb-4 hover:text-[#2d1b33]': currentTab !== 2 }" @click="currentTab = 2">
                    Friday · Dec 27
                </button>
                <button class="font-jakarta cursor-pointer transition" :class="{ 'border-b-2 border-[#2d1b33] pb-4 text-[#2d1b33]': currentTab === 3, 'text-gray-400 pb-4 hover:text-[#2d1b33]': currentTab !== 3 }" @click="currentTab = 3">
                    Sabbath · Dec 28
                </button>
            </div>
        </div>

        <!-- Schedule Timeline List -->
        <div class="space-y-0" x-show="currentTab === 1">
            <!-- Item 1 -->
            <div class="grid md:grid-cols-4 py-8 border-b border-gray-300/70 items-start gap-4">
                <div class="font-anton uppercase text-xs font-bold tracking-wider text-gray-400 pt-1">
                    3:00 PM
                </div>
                <div class="md:col-span-3">
                    <h4 class="font-jakarta text-xl font-medium text-[#2d1b33] mb-2">
                        Registration & Welcome
                    </h4>
                    <p class="font-jakarta text-sm text-gray-500 font-normal leading-relaxed max-w-xl">
                        Pick up your badge, connect with attendees, explore the exhibitor hall.
                    </p>
                </div>
            </div>

            <!-- Item 2 -->
            <div class="grid md:grid-cols-4 py-8 border-b border-gray-300/70 items-start gap-4">
                <div class="font-anton uppercase text-xs font-bold tracking-wider text-gray-400 pt-1">
                    6:30 PM
                </div>
                <div class="md:col-span-3 flex flex-col md:flex-row md:justify-between gap-2">
                    <div>
                        <h4 class="font-jakarta text-xl font-medium text-[#2d1b33] mb-2">
                            Opening Worship & Praise
                        </h4>
                        <p class="font-jakarta text-sm text-gray-500 font-normal leading-relaxed max-w-xl">
                            Unite in song, prayer, and praise as we begin together.
                        </p>
                    </div>
                    <div class="font-jakarta text-xs font-medium text-gray-500 md:text-right pt-1 whitespace-nowrap">
                        Worship Team
                    </div>
                </div>
            </div>

            <!-- Item 3 -->
            <div class="grid md:grid-cols-4 py-8 items-start gap-4">
                <div class="font-anton uppercase text-xs font-bold tracking-wider text-gray-400 pt-1">
                    7:30 PM
                </div>
                <div class="md:col-span-3 flex flex-col md:flex-row md:justify-between gap-2">
                    <div class="space-y-4">
                        <div>
                            <h4 class="font-jakarta text-xl font-medium text-[#2d1b33] mb-2">
                                Opening Keynote: "Arise"
                            </h4>
                            <p class="font-jakarta text-sm text-gray-500 font-normal leading-relaxed max-w-xl">
                                A call to wake from spiritual slumber and rise to the moment we were made for.
                            </p>
                        </div>
                        <div>
                            <span class="inline-block bg-[#d2f3ec] text-[#1e7a68] text-[10px] font-bold tracking-widest font-jakarta uppercase px-2.5 py-1 rounded-xs">
                                Keynote
                            </span>
                        </div>
                    </div>
                    <div class="font-jakarta text-xs font-medium text-gray-500 md:text-right pt-1 whitespace-nowrap">
                        David Kim
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-0" x-show="currentTab === 2">
            <!-- Item 1 -->
            <div class="grid md:grid-cols-4 py-8 border-b border-gray-300/70 items-start gap-4">
                <div class="font-anton uppercase text-xs font-bold tracking-wider text-gray-400 pt-1">
                    3:00 PM
                </div>
                <div class="md:col-span-3">
                    <h4 class="font-jakarta text-xl font-medium text-[#2d1b33] mb-2">
                        Registration & Welcome
                    </h4>
                    <p class="font-jakarta text-sm text-gray-500 font-normal leading-relaxed max-w-xl">
                        Pick up your badge, connect with attendees, explore the exhibitor hall.
                    </p>
                </div>
            </div>
        </div>

        <div class="space-y-0" x-show="currentTab === 3">
            <!-- Item 1 -->
            <div class="grid md:grid-cols-4 py-8 border-b border-gray-300/70 items-start gap-4">
                <div class="font-anton uppercase text-xs font-bold tracking-wider text-gray-400 pt-1">
                    3:00 PM
                </div>
                <div class="md:col-span-3">
                    <h4 class="font-jakarta text-xl font-medium text-[#2d1b33] mb-2">
                        Registration & Welcome
                    </h4>
                    <p class="font-jakarta text-sm text-gray-500 font-normal leading-relaxed max-w-xl">
                        Pick up your badge, connect with attendees, explore the exhibitor hall.
                    </p>
                </div>
            </div>
        </div>

    </div>
</section>