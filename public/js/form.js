let selectedFiles = [];

function previewImages(event) {
    const files = event.target.files;
    const previewContainer = document.getElementById('image-preview-container');
    const addPlaceholder = document.getElementById('add-image-placeholder');

    for (let i = 0; i < files.length; i++) {

        const file = files[i];
        console.log(file);
        selectedFiles.push(file);
        const reader = new FileReader();
        reader.onload = function (e) {
            const imageWrapper = document.createElement('div');
            imageWrapper.className = 'image-wrapper';
            imageWrapper.style.position = 'relative';
            imageWrapper.style.display = 'inline-block';

            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.maxWidth = '200px';
            img.style.height = 'auto';
            img.style.margin = '5px';

            const removeBtn = document.createElement('button');
            removeBtn.textContent = 'x';
            removeBtn.style.position = 'absolute';
            removeBtn.style.top = '5px';
            removeBtn.style.right = '5px';
            removeBtn.style.backgroundColor = 'red';
            removeBtn.style.color = 'white';
            removeBtn.style.border = 'none';
            removeBtn.style.borderRadius = '50%';
            removeBtn.style.width = '20px';
            removeBtn.style.height = '20px';
            removeBtn.style.cursor = 'pointer';
            removeBtn.onclick = function () {
                removeImage(removeBtn,i,imageWrapper);
            };

            imageWrapper.appendChild(img);
            imageWrapper.appendChild(removeBtn);
            previewContainer.insertBefore(imageWrapper, addPlaceholder); // Insert before the "+" placeholder
        };
        reader.readAsDataURL(file);
    }
}

function triggerFilePicker() {
    const fileInput = document.getElementById('images');
    fileInput.click(); // Programmatically click the hidden file input
}

function removeImage(button,index) {
    
    const imageWrapper = button.parentElement;
    imageWrapper.remove(); // Remove the image wrapper from the DOM

    var hiddenInput = imageWrapper.querySelector('input[type="hidden"]');
    console.log(hiddenInput);
    if (hiddenInput) {
        console.log('masuk');
        hiddenInput.disabled = true; // Menghapus input hidden yang berisi ID gambar
    }

    else {


        selectedFiles.splice(index, 1);
        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(file => {
            dataTransfer.items.add(file); // Re-add all remaining files to DataTransfer object
        });
        console.log(selectedFiles);
        console.log(dataTransfer.files);
        document.getElementById('images').files = dataTransfer.files; // Set the input files
        
    }
}