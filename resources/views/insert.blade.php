<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf_viewer.css">

    <title>Drag and Drop</title>
    <style>
        #pdfDisplay {
            width: 500px;
            height: 700px;
            border: 1px solid black;
            position: relative;
            overflow: hidden;
        }
        .draggable {
            width: 50px;
            height: 50px;
            position: absolute;
            cursor: pointer;
        }
    </style>
</head>
<body>
 
    <div id="dropzone">
    <div style="margin-top:107px" id="pdfDisplay"></div>
    
    </div>

    <img src="play-button.png" class="draggable" id="icon1" draggable="true">
   
   
   
   
<!-- Include the PDF.js library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf_viewer.min.js"></script>

<script src="pdf_insert.js"></script>
 <script src="script.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script >
// const dropzone = document.getElementById('dropzone');
// const icon = document.getElementById('icon1');
//const dropzone = document.getElementById('dropzone');
// dropzone.addEventListener('drop', (e) => {
//     e.preventDefault();
    
//     const x = e.clientX - dropzone.getBoundingClientRect().left;
//     const y = e.clientY - dropzone.getBoundingClientRect().top;

//     // Now, send x and y coordinates to the server to place the icon.
//     axios.post('/insert-icon', { x: x, y: y }).then(response => {
//         console.log(response.data.message);
//         // Reload the PDF with the inserted icon or provide a link to download.
//     }).catch(error => {
//         console.error("Error inserting icon:", error);
//     });
// });

// dropzone.addEventListener('dragover', (e) => {
//     e.preventDefault();
//     dropzone.style.backgroundColor = "#e9ecef"; // light gray
// });

// dropzone.addEventListener('dragleave', () => {
//     dropzone.style.backgroundColor = "white";
// });

// dropzone.addEventListener('drop', () => {
//     dropzone.style.backgroundColor = "white";
// });

</script>
</body>
</html>
