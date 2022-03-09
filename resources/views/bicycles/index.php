{% extends "layout.php" %}

{% block title %}Index{% endblock %}
{% block content %}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-xl font-semibold text-gray-900">Bicycles</h1>
            <p class="mt-2 text-sm text-gray-700">A list of all the bicycles.</p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            <a href="/bicycles/create" class="ml-6 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"> Create Bicycle </a>
        </div>
    </div>
    <div class="mt-8 flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Model</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Edit or delete</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        {% for bicycle in bicycles %}
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ bicycle.model }}</div>
                                <div class="text-sm text-gray-500">{{ bicycle.description }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">€{{ bicycle.price }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="/bicycles/{{ bicycle.id }}/edit" class="text-indigo-600 hover:text-indigo-900 pr-4">Edit</a>
                                <form action="/bicycles/{{ bicycle.id }}" method="POST">
                                    <input type="hidden" name="csrf_token" value="{{ csrf }}">
                                    <input type="hidden" name="_method" value="DELETE" />
                                    <input type="hidden" name="id" value="DELETE" />
                                    <button type="submit" class="text-indigo-600 hover:text-indigo-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                        {% endfor %}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
{% endblock %}