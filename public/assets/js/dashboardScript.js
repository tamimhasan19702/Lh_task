/** @format */

let currentPostId = null;

// Open confirmation modal with selected ID
function openConfirmModal(postId) {
  currentPostId = postId;
  document.getElementById("confirm-modal").classList.remove("hidden");
}

// Close confirmation modal
function closeConfirmModal() {
  document.getElementById("confirm-modal").classList.add("hidden");
  currentPostId = null;
}

// Delete post using selected ID
function deletePostConfirmed() {
  if (!currentPostId) {
    alert("No post selected.");
    return;
  }

  fetch(`delete-post.php?id=${currentPostId}`, {
    method: "DELETE",
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        const row = document.getElementById("post-row-" + currentPostId);
        const card = document.getElementById("post-card-" + currentPostId);

        if (row) row.remove();
        if (card) card.remove();

        alert("Post deleted successfully.");
        closeConfirmModal();
      } else {
        alert("Failed to delete post: " + data.message);
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("An unexpected error occurred.");
    });
}

function editPost(id) {
  fetch(`edit-post.php?id=${id}`)
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        const post = data.post;
        document.getElementById("post-id").value = id;
        document.getElementById("edit-title").value = post.title;
        document.getElementById("edit-description").value = post.description;

        document.getElementById("edit-modal").classList.remove("hidden");
      } else {
        showJsonSuccessAlert(data.message);
      }
    })
    .catch((error) => {
      console.error("Error fetching post:", error);
    });
}

function closeEditModal() {
  document.getElementById("edit-modal").classList.add("hidden");
}

document.addEventListener("DOMContentLoaded", () => {
  const editForm = document.getElementById("edit-form");

  if (editForm) {
    editForm.addEventListener("submit", function (event) {
      event.preventDefault();

      const formData = new FormData(this);

      fetch("update-post.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error("Network response was not ok");
          }
          return response.text();
        })
        .then((text) => {
          try {
            const data = JSON.parse(text);
            if (data.success) {
              closeEditModal();
              showJsonSuccessAlert(data.message);
              setTimeout(() => {
                location.reload();
              }, 3200);
            } else {
              alert("Failed to update post: " + data.message);
            }
          } catch (e) {
            console.error("Invalid JSON:", text);
            alert("Server returned invalid JSON. Check logs or backend.");
          }
        })
        .catch((error) => {
          console.error("AJAX Error:", error);
          alert("An unexpected error occurred.");
        });
    });
  }
});

document.getElementById("image").addEventListener("change", function (event) {
  const file = event.target.files[0];
  const preview = document.getElementById("imagePreview");

  if (file) {
    const reader = new FileReader();

    reader.onload = function (e) {
      preview.src = e.target.result;
    };

    reader.readAsDataURL(file);
  } else {
    preview.src = "";
  }
});
