@include('header')

<div>
    <!-- Modal untuk Tampilan Gambar -->
    <div id="imageModal" class="modal">
        <span class="close">&times;</span>

        <div class="modal-content">
            @if (!$encodedimages)
                <h2>No Image</h2>
            @else
                <div class="image-container">
                    @foreach ($encodedimages as $encodedImage)
                        <div class="image-wrapper">
                            <img src="data:{{ $encodedImage }};base64,{{ $encodedImage }}" alt="Image" />
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <div id="issueModal" class="modal"></div>

    <!-- CSS -->
    <style>
        /* Modal Background */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7); /* Background transparan gelap */
            display: none;
            justify-content: center;
            align-items: flex-start; /* Konten modal dimulai dari atas */
            z-index: 1000;
            overflow-y: auto; /* Modal bisa di-scroll secara vertikal */
        }

        /* Modal Content */
        .modal-content {
            background-color: #fff;
            border-radius: 8px;
            position: relative;
            width: 80%;
            max-width: 600px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.3s ease-in-out;
            display: flex;
            flex-direction: column;
            padding: 20px;
        }

        /* Image Container */
        .image-container {
            display: flex;
            flex-direction: column; /* Menyusun gambar secara vertikal */
            align-items: center; /* Gambar di tengah */
            gap: 10px; /* Jarak antar gambar */
        }

        /* Each image wrapper */
        .image-wrapper {
            width: 100%; /* Supaya gambar penuh dalam modal */
            display: flex;
            justify-content: center; /* Gambar di tengah */
        }

        /* Modal Image */
        .image-wrapper img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            border: 2px solid #ddd;
        }

        /* Close Button */
        .modal-content .close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 24px;
            color: #000;
            cursor: pointer;
            transition: color 0.3s;
        }

        .modal-content .close:hover {
            color: red;
        }

        /* Fade-in animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>

    <!-- JavaScript -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const modal = document.getElementById("imageModal");
            const closeModal = document.querySelector(".close");

            // Event Listener untuk tombol close
            closeModal.addEventListener("click", function() {
                modal.style.display = "none";
            });

            // Event Listener untuk klik di luar modal
            window.addEventListener("click", function(event) {
                if (event.target === modal) {
                    modal.style.display = "none";
                }
            });
        });
    </script>
</div>
