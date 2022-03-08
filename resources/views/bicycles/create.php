{% extends "layout.php" %}

{% block title %}Index{% endblock %}
{% block content %}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <form class="space-y-8 divide-y divide-gray-200" action="/bicycles/store" method="POST">
        <div class="space-y-8 divide-y divide-gray-200">
            <div>
                <input type="hidden" name="csrf_token" value="{{ csrf }}">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Create a Bicycle</h3>
                    <p class="mt-1 text-sm text-gray-500">Create a new Bicycle in the database.</p>
                </div>

                <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="sm:col-span-2">
                        <label for="first-name" class="block text-sm font-medium text-gray-700">Name</label>
                        <div class="mt-1">
                            <input type="text" name="first-name" id="first-name" autocomplete="given-name" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="last-name" class="block text-sm font-medium text-gray-700">Price</label>
                        <div class="mt-1">
                            <input type="text" name="last-name" id="last-name" autocomplete="family-name" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="country" class="block text-sm font-medium text-gray-700">Supplier</label>
                        <div class="mt-1">
                            <select id="country" name="country" autocomplete="country-name" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                {% for supplier in suppliers %}
                                <option value="{{ supplier.id }}">{{ supplier.name }}</option>
                                {% endfor %}
                            </select>
                        </div>
                    </div>

                    <div class="sm:col-span-6">
                        <label for="about" class="block text-sm font-medium text-gray-700">Description</label>
                        <div class="mt-1">
                            <textarea id="about" name="about" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md"></textarea>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">Optional bicycle description.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-5">
            <div class="flex justify-end">
                <a href="/" type="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Cancel</a>
                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Create</button>
            </div>
        </div>
    </form></div>
{% endblock %}