<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Faculty Research Upload
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg p-8">
                <form action="{{ route('research.faculty.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Project Name -->
                    <div class="mb-6">
                        <label class="block text-gray-800 font-semibold mb-2">Project Name</label>
                        <input type="text" name="project_name"
                            class="w-full border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200" required>
                    </div>

                    <!-- Members -->
                    <div class="mb-6">
                        <label class="block text-gray-800 font-semibold mb-2">Co-Researchers</label>
                        <input type="text" name="members"
                            class="w-full border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200" required>
                    </div>

                    <!-- Department -->
                    <div class="mb-6">
                        <label class="block text-gray-800 font-semibold mb-2">Department</label>
                        <select name="department"
                            class="w-full border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200" required>
                            <option value="Engineering Department">Engineering Department</option>
                            <option value="Computer Studies Department">Computer Studies Department</option>
                            <option value="Business Department">Business Department</option>
                            <option value="Education Department">Education Department</option>
                            <option value="Medical Department">Medical Department</option>
                        </select>
                    </div>

                    <!-- Abstract with Text Editor -->
                    <div class="mb-6">
                        <label class="block text-gray-800 font-semibold mb-2">Abstract</label>
                        <input id="abstract" type="hidden" name="abstract">
                        <trix-editor input="abstract" class="w-full border-gray-300 rounded-lg focus:ring focus:ring-blue-200"></trix-editor>
                    </div>

                    <!-- Banner Image Upload -->
                    <div class="mb-6">
                        <label class="block text-gray-800 font-semibold mb-2">Banner Image</label>
                        <div id="bannerPreviewContainer" class="mb-4 hidden">
                            <img id="bannerPreview" class="w-full h-40 object-cover rounded-lg shadow-lg">
                        </div>
                        <div id="bannerDropArea"
                            class="w-full border-2 border-dashed border-gray-400 rounded-lg px-6 py-8 text-center cursor-pointer hover:border-blue-500">
                            <p class="text-gray-600">Drag & Drop an image here or <span
                                    class="text-blue-500 font-semibold">click to browse</span></p>
                            <input type="file" name="banner_image" id="bannerInput" class="hidden" accept="image/*">
                        </div>
                    </div>

                    <!-- Research File Upload -->
                    <div class="mb-6">
                        <label class="block text-gray-800 font-semibold mb-2">Upload Research File (PDF, DOCX)</label>
                        <div id="fileDropArea"
                            class="w-full border-2 border-dashed border-gray-400 rounded-lg px-6 py-8 text-center cursor-pointer hover:border-blue-500">
                            <p class="text-gray-600">Drag & Drop your file here or <span
                                    class="text-blue-500 font-semibold">click to browse</span></p>
                            <input type="file" name="file" id="fileInput" class="hidden" accept=".pdf,.doc,.docx"
                                required>
                        </div>
                        <p id="fileName" class="text-sm text-gray-600 mt-2 hidden"></p>

                        <!-- PDF Preview -->
                        <div id="pdfPreviewContainer" class="hidden mt-4">
                            <iframe id="pdfPreview" class="w-full h-64 border rounded-lg"></iframe>
                        </div>
                    </div>

                    <!-- Submit & Archives Buttons -->
                    <div class="flex items-center justify-between">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold shadow-md transition">
                            Submit Research
                        </button>

                        <a href="{{ route('research.history') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-semibold shadow-md transition">
                            Research Archives
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.css">

    <script>
        document.getElementById('fileInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                document.getElementById('fileName').textContent = `Selected File: ${file.name}`;
                document.getElementById('fileName').classList.remove('hidden');
            }
        });

        function setupDragAndDrop(dropAreaId, inputId, fileNameId, previewId = null, previewContainerId = null) {
            const dropArea = document.getElementById(dropAreaId);
            const fileInput = document.getElementById(inputId);
            const fileNameDisplay = fileNameId ? document.getElementById(fileNameId) : null;
            const preview = previewId ? document.getElementById(previewId) : null;
            const previewContainer = previewContainerId ? document.getElementById(previewContainerId) : null;

            dropArea.addEventListener("click", () => fileInput.click());

            dropArea.addEventListener("dragover", (event) => {
                event.preventDefault();
                dropArea.classList.add("border-blue-500");
            });

            dropArea.addEventListener("dragleave", () => {
                dropArea.classList.remove("border-blue-500");
            });

            dropArea.addEventListener("drop", (event) => {
                event.preventDefault();
                dropArea.classList.remove("border-blue-500");

                if (event.dataTransfer.files.length > 0) {
                    fileInput.files = event.dataTransfer.files;
                    updatePreview(fileInput.files[0]);
                }
            });

            fileInput.addEventListener("change", (event) => {
                if (event.target.files.length > 0) {
                    updatePreview(event.target.files[0]);
                }
            });

            function updatePreview(file) {
                if (preview && file.type.startsWith("image/")) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        preview.src = e.target.result;
                        previewContainer.classList.remove("hidden");
                    };
                    reader.readAsDataURL(file);
                }

                if (fileNameDisplay) {
                    fileNameDisplay.textContent = `Selected File: ${file.name}`;
                    fileNameDisplay.classList.remove("hidden");
                }

                if (file.type === "application/pdf") {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        document.getElementById("pdfPreview").src = e.target.result;
                        document.getElementById("pdfPreviewContainer").classList.remove("hidden");
                    };
                    reader.readAsDataURL(file);
                }
            }
        }

        setupDragAndDrop("bannerDropArea", "bannerInput", null, "bannerPreview", "bannerPreviewContainer");
        setupDragAndDrop("fileDropArea", "fileInput", "fileName");
    </script>
</x-app-layout>