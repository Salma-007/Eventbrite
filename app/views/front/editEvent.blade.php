<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update Sponsor</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div id="updateForm" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="bg-white p-8 rounded-lg w-full max-w-2xl shadow-lg">
                <h2 class="text-2xl font-bold mb-6">Update Sponsor</h2>

                <form method="POST" action="/event" enctype="multipart/form-data" class="space-y-4">
                    <input type="hidden" name="id" value="{{ $sponsorById['id'] }}">

                    <div>
                        <label for="nameSponsor" class="block text-sm font-medium text-gray-700">Name</label>
                        <input value="{{ $sponsorById['name'] }}" type="text" name="name" id="nameSponsor" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Current Logo</label>
                        <img src="{{ 'sponsors/' . $sponsorById['logo'] }}" alt="Sponsor Logo" class="mt-2 w-32 h-32 object-cover border rounded-md shadow">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Upload New Logo</label>
                        <input type="file" name="logo" id="logoSponsor" accept="image/*" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="mt-6 flex justify-end space-x-4">
                        <a href="/event" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Cancel</a>
                        <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
