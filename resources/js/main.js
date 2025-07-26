Alpine.data("image_display", () => ({
    open: false,
    currentImageSrc: "",
    currentImageAlt: "",
    allImagesOpen: false,
    allImages: [],

    openModal(src, alt) {
        this.currentImageSrc = src;
        this.currentImageAlt = alt;
        this.open = true;
    },
    openAllImages() {
        if (this.allImages.length > 0) {
            this.currentImageAlt = "Gallery Images";
            this.open = true;
            this.allImagesOpen = true;
        }
    },
    closeModal() {
        this.currentImageSrc = "";
        this.currentImageAlt = "";
        this.allImagesOpen = false;
        this.open = false;
    },

    init(inputImages) {
        this.allImages = inputImages;
    },
}));
