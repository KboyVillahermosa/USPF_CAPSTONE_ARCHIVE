<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Upload Research Project
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <!-- Show validation errors -->
            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Show success message -->
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-lg rounded-lg p-8">
                <form action="{{ route('research.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Project Name -->
                    <div class="mb-6">
                        <label class="block text-gray-800 font-semibold mb-2">Research Title</label>
                        <input type="text" name="project_name"
                            class="w-full border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200" required>
                    </div>

                    <!-- Members -->
                    <div class="mb-6">
                        <label class="block text-gray-800 font-semibold mb-2">Authors</label>
                        <input type="text" name="members"
                            class="w-full border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200" required>
                    </div>

                    <!-- Department -->
                    <div class="mb-6">
                        <label class="block text-gray-800 font-semibold mb-2">Department</label>
                        <select name="department"
                            class="w-full border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200" required>
                            <option value="Engineering">Engineering</option>
                            <option value="Computer Science">Computer Science</option>
                            <option value="Business">Business</option>
                            <option value="Education">Education</option>
                            <option value="Medicine">Medicine</option>
                        </select>
                    </div>

                    <!-- Curriculum -->
                    <div class="mb-6">
                        <label class="block text-gray-800 font-semibold mb-2">Program</label>
                        <select name="curriculum"
                            class="w-full border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200" required>
                            <option value="">Select Program</option>
                            <option value="BSIT">Bachelor of Science in Information Technology</option>
                            <option value="BSCS">Bachelor of Science in Computer Science</option>
                            <option value="BSIS">Bachelor of Science in Information Systems</option>
                            <option value="BSCE">Bachelor of Science in Civil Engineering</option>
                            <option value="BSEE">Bachelor of Science in Electrical Engineering</option>
                            <option value="BSME">Bachelor of Science in Mechanical Engineering</option>
                            <option value="BSBA">Bachelor of Science in Business Administration</option>
                            <option value="BSA">Bachelor of Science in Accountancy</option>
                            <option value="BSMA">Bachelor of Science in Management Accounting</option>
                            <option value="BEED">Bachelor of Elementary Education</option>
                            <option value="BSED">Bachelor of Secondary Education</option>
                            <option value="BTVTEd">Bachelor of Technical-Vocational Teacher Education</option>
                        </select>
                    </div>

                    <!-- Abstract with Text Editor -->
                    <div class="mb-6">
                        <label class="block text-gray-800 font-semibold mb-2">Abstract</label>
                        <input id="abstract" type="hidden" name="abstract">
                        <trix-editor input="abstract"
                            class="w-full border-gray-300 rounded-lg focus:ring focus:ring-blue-200"></trix-editor>
                    </div>

                    <!-- Add this right before the file upload section -->
                    <div id="versionDetails" class="mb-6 hidden">
                        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
                            <p>A research paper with this title already exists. This will be saved as a new version.</p>
                        </div>
                        <label class="block text-gray-800 font-semibold mb-2">What's new in this version?</label>
                        <textarea name="version_description" 
                            class="w-full border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200"
                            rows="3"
                            placeholder="Describe the changes or improvements in this version..."></textarea>
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
                            Submit
                        </button>

                        <a href="{{ route('research.history') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-semibold shadow-md transition">
                            My Archives
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
        // Initialize Quill Text Editor
        document.getElementById('fileInput').addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file) {
                document.getElementById('fileName').textContent = `Selected File: ${file.name}`;
            }
        });

        document.querySelector('input[name="project_name"]').addEventListener('blur', async function() {
            const projectName = this.value;
            const response = await fetch(`/api/check-duplicate/${encodeURIComponent(projectName)}`);
            const data = await response.json();
            
            if (data.exists) {
                document.getElementById('versionDetails').classList.remove('hidden');
            } else {
                document.getElementById('versionDetails').classList.add('hidden');
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