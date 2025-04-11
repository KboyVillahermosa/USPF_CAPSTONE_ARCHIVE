<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upload Dissertation/Thesis') }}
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
                <form action="{{ route('dissertation.store') }}" method="POST" enctype="multipart/form-data" id="dissertationForm">
                    @csrf

                    <!-- Title -->
                    <div class="mb-6">
                        <label class="block text-gray-800 font-semibold mb-2">Title</label>
                        <input type="text" name="title" value="{{ old('title') }}"
                            class="w-full border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200" required>
                    </div>

                    <!-- Author -->
                    <div class="mb-6">
                        <label class="block text-gray-800 font-semibold mb-2">Author</label>
                        <input type="text" name="author" value="{{ old('author') }}"
                            class="w-full border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200" required>
                    </div>

                    <!-- Type -->
                    <div class="mb-6">
                        <label class="block text-gray-800 font-semibold mb-2">Type</label>
                        <select name="type" class="w-full border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200" required>
                            <option value="">Select Type</option>
                            <option value="dissertation" {{ old('type') == 'dissertation' ? 'selected' : '' }}>Dissertation</option>
                            <option value="thesis" {{ old('type') == 'thesis' ? 'selected' : '' }}>Thesis</option>
                        </select>
                    </div>

                    <!-- Department -->
                    <div class="mb-6">
                        <label class="block text-gray-800 font-semibold mb-2">Department</label>
                        <select name="department" id="dissertation_department"
                            class="w-full border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200" required>
                            <option value="">Select Department</option>
                            <option value="College of Engineering and Architecture" {{ old('department') == 'College of Engineering and Architecture' ? 'selected' : '' }}>College of Engineering and Architecture</option>
                            <option value="College of Computer Studies" {{ old('department') == 'College of Computer Studies' ? 'selected' : '' }}>College of Computer Studies</option>
                            <option value="College of Health Sciences" {{ old('department') == 'College of Health Sciences' ? 'selected' : '' }}>College of Health Sciences</option>
                            <option value="College of Social Work" {{ old('department') == 'College of Social Work' ? 'selected' : '' }}>College of Social Work</option>
                            <option value="College of Teacher Education, Arts and Sciences" {{ old('department') == 'College of Teacher Education, Arts and Sciences' ? 'selected' : '' }}>College of Teacher Education, Arts and Sciences</option>
                            <option value="School of Business and Accountancy" {{ old('department') == 'School of Business and Accountancy' ? 'selected' : '' }}>School of Business and Accountancy</option>
                            <option value="Graduate School" {{ old('department') == 'Graduate School' ? 'selected' : '' }}>Graduate School</option>
                            <option value="other">Other (specify)</option>
                        </select>
                        <div id="otherDepartmentContainer_dissertation" class="mt-2 hidden">
                            <input type="text" id="otherDepartment_dissertation"
                                class="w-full border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200"
                                placeholder="Enter department name">
                        </div>
                    </div>

                    <!-- Year -->
                    <div class="mb-6">
                        <label class="block text-gray-800 font-semibold mb-2">Year</label>
                        <input type="number" name="year" value="{{ old('year', date('Y')) }}"
                            class="w-full border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200" 
                            min="1900" max="{{ date('Y') + 1 }}" required>
                    </div>

                    <!-- Abstract with Text Editor -->
                    <div class="mb-6">
                        <label class="block text-gray-800 font-semibold mb-2">Abstract</label>
                        <input id="dissertation_abstract" type="hidden" name="abstract" value="{{ old('abstract') }}">
                        <trix-editor input="dissertation_abstract"
                            class="w-full border-gray-300 rounded-lg focus:ring focus:ring-blue-200"></trix-editor>
                    </div>

                    <!-- Keywords -->
                    <div class="mb-6">
                        <label class="block text-gray-800 font-semibold mb-2">Keywords (comma separated)</label>
                        <input type="text" name="keywords" value="{{ old('keywords') }}"
                            class="w-full border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200" required>
                    </div>

                    <!-- File Upload -->
                    <div class="mb-6">
                        <label class="block text-gray-800 font-semibold mb-2">Upload Document (PDF, DOCX)</label>
                        <div id="dissertationFileDropArea"
                            class="w-full border-2 border-dashed border-gray-400 rounded-lg px-6 py-8 text-center cursor-pointer hover:border-blue-500">
                            <p class="text-gray-600">Drag & Drop your file here or <span
                                    class="text-blue-500 font-semibold">click to browse</span></p>
                            <input type="file" name="file" id="dissertationFileInput" class="hidden" accept=".pdf,.doc,.docx"
                                required>
                        </div>
                        <p id="dissertationFileName" class="text-sm text-gray-600 mt-2 hidden"></p>

                        <!-- PDF Preview -->
                        <div id="dissertationPdfPreviewContainer" class="hidden mt-4">
                            <iframe id="dissertationPdfPreview" class="w-full h-64 border rounded-lg"></iframe>
                        </div>
                    </div>

                    <!-- Submit & Archives Buttons -->
                    <div class="flex items-center justify-between">
                        <button type="submit" id="dissertationSubmitButton"
                            class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-lg font-semibold shadow-md transition">
                            Submit
                        </button>

                        <a href="{{ route('history') }}"
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
        // Handle custom department
        const departmentSelect = document.getElementById('dissertation_department');
        const otherDepartmentContainer = document.getElementById('otherDepartmentContainer_dissertation');
        const otherDepartment = document.getElementById('otherDepartment_dissertation');
        const dissertationForm = document.getElementById('dissertationForm');
        
        departmentSelect.addEventListener('change', function() {
            if (this.value === 'other') {
                otherDepartmentContainer.classList.remove('hidden');
                otherDepartment.setAttribute('required', 'required');
            } else {
                otherDepartmentContainer.classList.add('hidden');
                otherDepartment.removeAttribute('required');
            }
        });
        
        // Check if "other" is selected on page load (in case of form validation errors)
        if (departmentSelect.value === 'other') {
            otherDepartmentContainer.classList.remove('hidden');
            otherDepartment.setAttribute('required', 'required');
        }
        
        // Handle form submission
        dissertationForm.addEventListener('submit', function(e) {
            // If "other" is selected, we need to use the custom value
            if (departmentSelect.value === 'other' && otherDepartment.value.trim()) {
                e.preventDefault(); // Stop the form from submitting normally
                
                // Get the original select element
                const originalSelect = departmentSelect;
                
                // Change the value of the select to the custom department value
                originalSelect.value = otherDepartment.value.trim();
                
                // Submit the form
                this.submit();
            }
        });

        // File handling
        document.getElementById('dissertationFileInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                document.getElementById('dissertationFileName').textContent = `Selected File: ${file.name}`;
                document.getElementById('dissertationFileName').classList.remove('hidden');
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
                if (fileNameDisplay) {
                    fileNameDisplay.textContent = `Selected File: ${file.name}`;
                    fileNameDisplay.classList.remove("hidden");
                }

                if (file.type === "application/pdf") {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById("dissertationPdfPreview").src = e.target.result;
                        document.getElementById("dissertationPdfPreviewContainer").classList.remove("hidden");
                    };
                    reader.readAsDataURL(file);
                }
            }
        }

        setupDragAndDrop("dissertationFileDropArea", "dissertationFileInput", "dissertationFileName", "dissertationPdfPreview", "dissertationPdfPreviewContainer");
    </script>
</x-app-layout>