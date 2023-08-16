<aside id="sidebar"
    class="static pt-4 lg:fixed top-0 left-0 z-20 flex flex-col flex-shrink-0 w-max lg:w-64 h-full lg:pt-24 font-normal duration-75 flex transition-width"
    aria-label="Sidebar">
    <div
        class="relative flex flex-col flex-1 min-h-0 pt-0 bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="flex flex-col flex-1 pb-4 overflow-y-auto">
            <div class="flex-1 px-3 space-y-1 bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                <ul class="pb-2 space-y-2">
                    <x-sidebar-link label="Dashboard" icon="home.svg" routeName="dashboard" />
                    <x-sidebar-link label="Proposed services" icon="code.svg" routeName="services.index" />
                    <x-sidebar-link label="Received Requests" icon="letter.svg" routeName="serviceRequests.received" />
                    <x-sidebar-link label="Sent Requests" icon="map-arrow.svg"
                        routeName="serviceRequests.sent" />
                    <x-sidebar-link label="Missions" icon="list.svg" routeName="missions.index" />
                    <x-sidebar-link label="Service Board" icon="compass.svg" routeName="serviceBoard" />
                </ul>
            </div>
        </div>
    </div>
</aside>
