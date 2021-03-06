<!DOCTYPE html>
<html class="h-full bg-white" lang="en">
<head>
    <title>{% block title %}{% endblock %} - PHP Assignment</title>
    <link href="/public/css/app.css" rel="stylesheet">
</head>
<body class="h-full">
<header class="bg-white shadow-sm lg:static lg:overflow-y-visible">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 lg:divide-y lg:divide-gray-200">
        <div class="relative flex justify-between xl:grid xl:grid-cols-12 lg:gap-8">
            <div class="flex md:absolute md:left-0 md:inset-y-0 lg:static xl:col-span-2">
                <div class="flex-shrink-0 flex items-center">
                    <a href="/">
                        <img class="block h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-mark.svg?color=indigo&shade=600" alt="Workflow">
                    </a>
                </div>
            </div>
            <div class="min-w-0 flex-1 md:px-8 lg:px-0 xl:col-span-6">
                <div class="flex items-center px-6 py-4 md:max-w-3xl md:mx-auto lg:max-w-none lg:mx-0 xl:px-0">
                    <div class="w-full">
                        <label for="search" class="sr-only">Search</label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 pl-3 flex items-center">
                                <!-- Heroicon name: solid/search -->
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <form action="/bicycles" method="GET">
                                <input id="search" name="search" class="block w-full bg-white border border-gray-300 rounded-md py-2 pl-10 pr-3 text-sm placeholder-gray-500 focus:outline-none focus:text-gray-900 focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Search for a bicycle by model" type="search" value="{{ search }}">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <nav class="py-4 flex space-x-8" aria-label="Global">
            <a href="/bicycles" class="rounded-md py-2 px-3 inline-flex items-center text-sm font-medium" aria-current="page">Bicycles</a>

            <a href="/suppliers" class="rounded-md py-2 px-3 inline-flex items-center text-sm font-medium">Suppliers</a>
        </nav>
    </div>
</header>
<div class="pt-10">{% block content %}{% endblock %}</div>
</body>
</html>