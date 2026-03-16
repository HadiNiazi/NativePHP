<div class="lg:col-span-2 space-y-6">
    <div class="bg-white rounded-xl shadow-lg p-6">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-4">
            <h3 class="text-2xl font-bold text-gray-800">My Tasks</h3>
            <div class="flex gap-4 flex-wrap">
                <div class="flex items-center gap-2">
                    <label class="text-sm font-medium text-gray-600">Filter:</label>
                    <select class="border-2 border-gray-200 rounded-md px-2 py-1 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500">
                        <option>All Tasks</option>
                        <option>Pending</option>
                        <option>In Progress</option>
                        <option>Completed</option>
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    <label class="text-sm font-medium text-gray-600">Sort:</label>
                    <select class="border-2 border-gray-200 rounded-md px-2 py-1 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500">
                        <option>Newest First</option>
                        <option>Due Date</option>
                        <option>Priority</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Task Items -->
        <div class="space-y-4">

            <!-- Task 1 -->
            <div class="bg-gray-50 border-l-4 border-red-500 rounded-md p-4 hover:shadow-md transition-transform transform hover:translate-x-1">
                <!-- First Row: Title and Actions -->
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <input type="checkbox" class="w-5 h-5 accent-indigo-500">
                        <div class="flex items-center gap-2 flex-wrap">
                            <h4 class="font-semibold text-gray-800">Complete Website Homepage Design</h4>
                            <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-red-100 text-red-700">High</span>
                            <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Pending</span>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button class="text-indigo-500 hover:bg-indigo-100 px-2 rounded">✎</button>
                        <button class="text-red-500 hover:bg-red-100 px-2 rounded">✕</button>
                    </div>
                </div>
                <!-- Second Row: Description -->
                <p class="text-gray-600 mt-3">Design and finalize the homepage UI including hero section and service blocks.</p>
                <!-- Third Row: Dates -->
                <div class="flex gap-6 text-gray-500 text-sm mt-2">
                    <span>📅 Due: Mar 20, 2026</span>
                    <span>Created: 2 days ago</span>
                </div>
            </div>

            <!-- Task 2 -->
            <div class="bg-gray-50 border-l-4 border-yellow-500 rounded-md p-4 hover:shadow-md transition-transform transform hover:translate-x-1">
                <!-- First Row: Title and Actions -->
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <input type="checkbox" class="w-5 h-5 accent-indigo-500">
                        <div class="flex items-center gap-2 flex-wrap">
                            <h4 class="font-semibold text-gray-800">Fix Laravel Email Notification Bug</h4>
                            <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Medium</span>
                            <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-gray-200 text-gray-800">In Progress</span>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button class="text-indigo-500 hover:bg-indigo-100 px-2 rounded">✎</button>
                        <button class="text-red-500 hover:bg-red-100 px-2 rounded">✕</button>
                    </div>
                </div>
                <!-- Second Row: Description -->
                <p class="text-gray-600 mt-3">Investigate SMTP configuration and fix failed email sending.</p>
                <!-- Third Row: Dates -->
                <div class="flex gap-6 text-gray-500 text-sm mt-2">
                    <span>📅 Due: Mar 18, 2026</span>
                    <span>Created: 5 hours ago</span>
                </div>
            </div>

            <!-- Task 3 -->
            <div class="bg-gray-50 border-l-4 border-green-500 rounded-md p-4 hover:shadow-md transition-transform transform hover:translate-x-1">
                <!-- First Row: Title and Actions -->
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <input type="checkbox" checked class="w-5 h-5 accent-indigo-500">
                        <div class="flex items-center gap-2 flex-wrap">
                            <h4 class="font-semibold text-gray-800 line-through">Setup Project GitHub Repository</h4>
                            <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-green-100 text-green-800">Low</span>
                            <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button class="text-indigo-500 hover:bg-indigo-100 px-2 rounded">✎</button>
                        <button class="text-red-500 hover:bg-red-100 px-2 rounded">✕</button>
                    </div>
                </div>
                <!-- Second Row: Description -->
                <p class="text-gray-600 mt-3">Initialize repository, push initial Laravel project and configure branches.</p>
                <!-- Third Row: Dates -->
                <div class="flex gap-6 text-gray-500 text-sm mt-2">
                    <span>📅 Due: Mar 10, 2026</span>
                    <span>Created: 1 week ago</span>
                </div>
            </div>
        </div>

        <!-- Task Stats -->
        <div class="bg-gray-100 rounded-md p-4 mt-4 flex justify-around font-semibold text-gray-700">
            <span>Total Tasks: 3</span>
            <span>Completed: 1</span>
        </div>

    </div>
</div>
