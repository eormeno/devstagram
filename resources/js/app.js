import Dropzone from "dropzone";

Dropzone.autoDiscover = false;

if (document.getElementById("dropzone") !== null) {

	const dropzone = new Dropzone("#dropzone", {
		dictDefaultMessage: "Drop files here to upload",
		acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg",
		maxFiles: 1,
		addRemoveLinks: true,
		dictRemoveFile: "Remove file",
		uploadMultiple: false,

		init: function () {
			if (document.querySelector('[name="image"]').value.trim()) {
				const publishedImage = {};
				publishedImage.size = 1234;
				publishedImage.name = document.querySelector('[name="image"]').value;
				this.options.addedfile.call(this, publishedImage);
				this.options.thumbnail.call(this, publishedImage, `/uploads/${publishedImage.name}`);

				publishedImage.previewElement.classList.add("dz-success", "dz-complete");
			}
		}
	});

	dropzone.on("success", function (file, response) {
		document.querySelector('[name="image"]').value = response.image;
	});

	dropzone.on("removedfile", function (file) {
		document.querySelector('[name="image"]').value = "";
	})
}