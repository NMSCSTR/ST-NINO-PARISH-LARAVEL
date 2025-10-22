<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Santo Niño Parish Church</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#fef2f2',
                            100: '#fee2e2',
                            500: '#ef4444',
                            600: '#dc2626',
                            700: '#b91c1c',
                            900: '#7f1d1d',
                        },
                        secondary: {
                            50: '#fff7ed',
                            100: '#ffedd5',
                            500: '#f97316',
                            600: '#ea580c',
                            700: '#c2410c',
                        },
                        accent: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            900: '#312e81',
                        }
                    },
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                    },
                    boxShadow: {
                        'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04)',
                        'card': '0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03)',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 font-sans">
    <section>
        <div class="min-h-screen pt-24">
            <!-- Background elements -->
            <div class="fixed inset-0 -z-10 overflow-hidden">
                <div class="absolute -top-40 -right-32 w-80 h-80 bg-primary-100 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse-slow"></div>
                <div class="absolute -bottom-40 -left-32 w-80 h-80 bg-accent-100 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse-slow animation-delay-2000"></div>
            </div>

            <!-- Top Navigation (placeholder) -->
            <div class="fixed top-0 left-0 right-0 bg-white shadow-card z-40">
                <div class="px-4 lg:px-10 py-4 flex justify-between items-center">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-primary-500 to-secondary-500 flex items-center justify-center text-white font-bold">
                            SN
                        </div>
                        <h1 class="ml-3 text-xl font-semibold text-gray-800">Santo Niño Parish Church</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button class="p-2 rounded-full bg-gray-100 hover:bg-gray-200 transition-colors">
                            <span class="material-icons-outlined text-gray-600">notifications</span>
                        </button>
                        <div class="flex items-center space-x-2 cursor-pointer">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-primary-500 to-accent-500"></div>
                            <span class="text-gray-700 font-medium">Admin</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row px-4 lg:px-10 pb-4 gap-6">

                {{-- Sidebar --}}
                <div class="lg:w-2/12 w-full">
                    <div class="bg-white rounded-2xl shadow-card p-6 sticky top-32">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Navigation</h3>
                        <ul class="space-y-2">
                            <li>
                                <a href="#" class="flex items-center p-3 rounded-xl bg-primary-50 text-primary-600 font-medium">
                                    <span class="material-icons-outlined mr-3">dashboard</span>
                                    Dashboard
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center p-3 rounded-xl text-gray-600 hover:bg-gray-50 transition-colors">
                                    <span class="material-icons-outlined mr-3">group</span>
                                    Members
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center p-3 rounded-xl text-gray-600 hover:bg-gray-50 transition-colors">
                                    <span class="material-icons-outlined mr-3">event</span>
                                    Events
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center p-3 rounded-xl text-gray-600 hover:bg-gray-50 transition-colors">
                                    <span class="material-icons-outlined mr-3">inventory_2</span>
                                    Reservations
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center p-3 rounded-xl text-gray-600 hover:bg-gray-50 transition-colors">
                                    <span class="material-icons-outlined mr-3">mail</span>
                                    Messages
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center p-3 rounded-xl text-gray-600 hover:bg-gray-50 transition-colors">
                                    <span class="material-icons-outlined mr-3">settings</span>
                                    Settings
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Main Content --}}
                <div class="lg:w-10/12 w-full">
                    <div class="flex flex-col lg:flex-row gap-6 mb-6">
                        {{-- Welcome Card --}}
                        <div class="flex-1 bg-gradient-to-br from-primary-50 to-primary-100 border border-primary-200 rounded-2xl p-6 relative overflow-hidden shadow-card">
                            <div class="absolute -right-6 -bottom-6 opacity-20 text-primary-500 text-[140px] pointer-events-none">
                                <span class="material-icons-outlined">emoji_people</span>
                            </div>

                            <div class="relative z-10">
                                <p class="text-lg text-gray-600 mb-1">Welcome back,</p>
                                <h2 class="text-3xl font-bold text-accent-900 leading-tight mb-4">
                                    {{ Str::ucfirst(auth()->user()->role) }} {{ auth()->user()->firstname }}
                                </h2>

                                <div class="mt-6">
                                    <span class="bg-gradient-to-r from-primary-500 to-primary-600 text-white text-sm px-5 py-2.5 rounded-full font-medium shadow-card inline-flex items-center">
                                        <i class="material-icons-outlined text-base align-middle mr-2">access_time</i>
                                        {{ now()->setTimezone('Asia/Manila')->format('l, F j, Y h:i A') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Inbox Card --}}
                        <div class="flex-1 bg-gradient-to-br from-secondary-50 to-secondary-100 border border-secondary-200 rounded-2xl p-6 relative overflow-hidden shadow-card">
                            <div class="absolute -right-6 -bottom-6 opacity-20 text-secondary-500 text-[140px] pointer-events-none">
                                <span class="material-icons-outlined">mail</span>
                            </div>

                            <div class="relative z-10">
                                <p class="text-lg text-gray-600 mb-1">Inbox</p>
                                <h2 class="text-3xl font-bold text-accent-900 leading-tight mb-4">23 Messages</h2>

                                <div class="mt-6">
                                    <a href="#" class="inline-flex items-center bg-gradient-to-r from-secondary-500 to-secondary-600 hover:from-secondary-600 hover:to-secondary-700 text-white text-sm px-5 py-2.5 rounded-full font-medium shadow-card transition-all duration-300 transform hover:-translate-y-0.5">
                                        <i class="material-icons-outlined text-base align-middle mr-2">mark_email_unread</i>
                                        See Messages
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                        <!-- Total Members -->
                        <div class="bg-white rounded-2xl shadow-card p-6 flex items-center justify-between transition-all duration-300 hover:shadow-lg hover:transform hover:-translate-y-1">
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Total Members</p>
                                <h3 class="text-2xl font-bold text-gray-800 mt-1">1,247</h3>
                                <p class="text-xs text-green-500 mt-2 flex items-center">
                                    <span class="material-icons-outlined text-sm mr-1">trending_up</span>
                                    <span>+12% from last month</span>
                                </p>
                            </div>
                            <div class="w-14 h-14 rounded-full bg-blue-50 flex items-center justify-center">
                                <span class="material-icons-outlined text-3xl text-blue-500">group</span>
                            </div>
                        </div>

                        <!-- Upcoming Events -->
                        <div class="bg-white rounded-2xl shadow-card p-6 flex items-center justify-between transition-all duration-300 hover:shadow-lg hover:transform hover:-translate-y-1">
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Upcoming Events</p>
                                <h3 class="text-2xl font-bold text-gray-800 mt-1">8</h3>
                                <p class="text-xs text-blue-500 mt-2 flex items-center">
                                    <span class="material-icons-outlined text-sm mr-1">event_available</span>
                                    <span>Next: Sunday Mass</span>
                                </p>
                            </div>
                            <div class="w-14 h-14 rounded-full bg-orange-50 flex items-center justify-center">
                                <span class="material-icons-outlined text-3xl text-orange-500">event</span>
                            </div>
                        </div>

                        <!-- New Reservations -->
                        <div class="bg-white rounded-2xl shadow-card p-6 flex items-center justify-between transition-all duration-300 hover:shadow-lg hover:transform hover:-translate-y-1">
                            <div>
                                <p class="text-gray-500 text-sm font-medium">New Reservations</p>
                                <h3 class="text-2xl font-bold text-gray-800 mt-1">14</h3>
                                <p class="text-xs text-purple-500 mt-2 flex items-center">
                                    <span class="material-icons-outlined text-sm mr-1">schedule</span>
                                    <span>5 pending approval</span>
                                </p>
                            </div>
                            <div class="w-14 h-14 rounded-full bg-green-50 flex items-center justify-center">
                                <span class="material-icons-outlined text-3xl text-green-500">event_available</span>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity Section -->
                    <div class="mt-8">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Recent Activity</h3>
                        <div class="bg-white rounded-2xl shadow-card overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Activity</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="w-8 h-8 rounded-full bg-gradient-to-r from-primary-500 to-accent-500 mr-3"></div>
                                                    <div>
                                                        <div class="text-sm font-medium text-gray-900">Maria Santos</div>
                                                        <div class="text-xs text-gray-500">Baptism</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Reservation submitted</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Today, 10:30 AM</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                            </td>
                                        </tr>
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="w-8 h-8 rounded-full bg-gradient-to-r from-green-500 to-blue-500 mr-3"></div>
                                                    <div>
                                                        <div class="text-sm font-medium text-gray-900">Juan Dela Cruz</div>
                                                        <div class="text-xs text-gray-500">Wedding</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Payment received</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Yesterday, 3:45 PM</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                                            </td>
                                        </tr>
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="w-8 h-8 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 mr-3"></div>
                                                    <div>
                                                        <div class="text-sm font-medium text-gray-900">Ana Reyes</div>
                                                        <div class="text-xs text-gray-500">Confirmation</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Event registration</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Oct 12, 2:15 PM</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Confirmed</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        @keyframes pulse-slow {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 0.5; }
        }
        .animate-pulse-slow {
            animation: pulse-slow 6s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
    </style>
</body>
</html>
