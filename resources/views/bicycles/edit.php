{% extends "layout.php" %}

{% block title %}Index{% endblock %}
{% block content %}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <form class="space-y-8 divide-y divide-gray-200" action="/bicycles/{{ bicycle.id }}" method="POST">
        <div class="space-y-8 divide-y divide-gray-200">
            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                <div class="sm:col-span-3">
                    <input type="hidden" name="csrf_token" value="{{ csrf }}">
                    <input type="hidden" name="_method" value="PATCH" />
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Create a Bicycle</h3>
                        <p class="mt-1 text-sm text-gray-500">Create a new Bicycle in the database.</p>
                    </div>

                    <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-3">
                            <label for="first-name" class="block text-sm font-medium text-gray-700">Model</label>
                            <div class="mt-1">
                                <input required type="text" name="model" id="first-name" autocomplete="given-name" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" value="{{ bicycle.model }}">
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="last-name" class="block text-sm font-medium text-gray-700">Price</label>
                            <div class="mt-1">
                                <input required type="text" name="price" id="last-name" autocomplete="family-name" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" value="{{ bicycle.price }}">
                            </div>
                        </div>

                        <div class="sm:col-span-6">
                            <label for="about" class="block text-sm font-medium text-gray-700">Description</label>
                            <div class="mt-1">
                                <textarea id="about" name="description" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md">{{ bicycle.description }}</textarea>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">Optional bicycle description.</p>
                        </div>
                    </div>
                </div>
                <div class="sm:col-span-3">
                    <fieldset>
                        <legend class="text-lg font-medium text-gray-900">Suppliers</legend>
                        <div class="mt-4 border-t border-b border-gray-200 divide-y divide-gray-200">
                            {% for supplier in suppliers %}
                            <div class="relative flex items-start py-4">
                                <div class="min-w-0 flex-1 text-sm">
                                    <label for="person-1" class="font-medium text-gray-700 select-none">{{ supplier.name }}</label>
                                </div>
                                <div class="ml-3 flex items-center h-5">
                                    <input {% if supplier.id in active_suppliers %} checked {% endif %} id="person-1" name="suppliers[]" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" value="{{ supplier.id }}">
                                </div>
                            </div>
                            {% endfor %}
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>

        <div class="pt-5">
            <div class="flex justify-end">
                <a href="/" type="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Cancel</a>
                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Update</button>
            </div>
        </div>
    </form></div>
{% endblock %}