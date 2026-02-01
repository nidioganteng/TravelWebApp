export default function imageUploader() {
    return {
        uploads: [],
        allFiles: new DataTransfer(),

        handleUpload(event) {
            const selectedFiles = Array.from(event.target.files);
            if (selectedFiles.length === 0) return;

            const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/svg+xml'];
            const maxSizeInKB = 2048;

            selectedFiles.forEach((file) => {
                if (!validTypes.includes(file.type) || (file.size / 1024) > maxSizeInKB) {
                    alert(`File ${file.name} file invalid or too large!`);
                    return;
                }
                this.allFiles.items.add(file);

                const fileId = Date.now() + Math.random();
                const fileData = {
                    id: fileId,
                    name: file.name,
                    size: (file.size / 1024).toFixed(0) + ' KB',
                    progress: 0,
                    status: 'uploading'
                };
                this.uploads.push(fileData);

                let currentProgress = 0;
                const interval = setInterval(() => {
                    const item = this.uploads.find(u => u.id === fileId);
                    if (!item) { 
                        clearInterval(interval); 
                        return; 
                    }
                    
                    if (currentProgress < 100) {
                        currentProgress += Math.floor(Math.random() * 20) + 10;
                        item.progress = Math.min(currentProgress, 100);
                    } else {
                        item.status = 'success';
                        clearInterval(interval);
                    }
                }, 200);
            });

            this.syncInput();
        },

        removeItem(id) {
            const indexToRemove = this.uploads.findIndex(u => u.id === id);
            if (indexToRemove === -1) return;

            this.uploads.splice(indexToRemove, 1);

            const newDataTransfer = new DataTransfer();
            Array.from(this.allFiles.files).forEach((file, i) => {
                if (i !== indexToRemove) newDataTransfer.items.add(file);
            });
            this.allFiles = newDataTransfer;

            this.syncInput();
        },

        syncInput() {
            const input = document.querySelector('input[name="product_image[]"]');
            if (input) {
                input.files = this.allFiles.files;
            }
        }
    }
}