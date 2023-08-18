<aside id="sidebar"
    class="static pt-4 lg:fixed top-0 left-0 z-20 flex flex-col flex-shrink-0 w-max lg:w-64 h-full lg:pt-24 font-normal duration-75 flex transition-width"
    aria-label="Sidebar">
    <div class="relative flex flex-col flex-1 min-h-0 pt-0 bg-white border-r border-gray-200  ">
        <div class="flex flex-col flex-1 pb-4 overflow-y-auto">
            <div class="flex-1 flex flex-col px-3 bg-white divide-y divide-gray-200  ">
                <ul class="pb-2 space-y-2">
                    <x-sidebar-link label="Dashboard" icon="home.svg" routeName="dashboard" />
                    <x-sidebar-link label="My services" icon="code.svg" routeName="services.index" />
                    <x-sidebar-link label="Received Requests" icon="letter.svg" routeName="serviceRequests.received" />
                    <x-sidebar-link label="Sent Requests" icon="map-arrow.svg" routeName="serviceRequests.sent" />
                    <x-sidebar-link label="Missions" icon="list.svg" routeName="missions.index" />
                    <x-sidebar-link label="Service Board" icon="compass.svg" routeName="serviceBoard" />
                </ul>
                <div class="px-3 text-xs mt-auto">
                    Vectors and icons by <a
                        href="https://www.figma.com/community/file/1166831539721848736?ref=svgrepo.com"
                        target="_blank">Solar Icons</a> in CC Attribution License via <a href="https://www.svgrepo.com/"
                        target="_blank">SVG Repo</a>
                </div>
            </div>
        </div>
    </div>
</aside>
