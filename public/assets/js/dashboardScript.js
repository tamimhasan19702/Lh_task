/** @format */

function deletePost(id) {
  if (confirm("Are you sure you want to delete this post?")) {
    fetch(`delete-post.php?id=${id}`, {
      method: "DELETE",
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          document.getElementById("post-row-" + id).remove();
          document.getElementById("post-card-" + id)?.remove();
          alert("Post deleted successfully.");
        } else {
          alert("Failed to delete post: " + data.message);
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("An unexpected error occurred.");
      });
  }
}

function openEditModal(postId) {
  // Fetch post data via AJAX
  fetch(`edit-post.php?id=${postId}`)
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        const post = data.post;
        document.getElementById("edit-title").value = post.title;
        document.getElementById("edit-description").value = post.description;
        document.getElementById("post-id").value = postId;
        document.getElementById("edit-modal").classList.remove("hidden");
      } else {
        alert("Failed to load post data.");
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("An unexpected error occurred.");
    });
}

function closeEditModal() {
  document.getElementById("edit-modal").classList.add("hidden");
}

document.addEventListener("DOMContentLoaded", () => {
  const editForm = document.getElementById("edit-form");
  editForm.addEventListener("submit", function (event) {
    event.preventDefault();

    const formData = new FormData(editForm);
    const postId = formData.get("post_id");

    fetch(`update-post.php`, {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          alert("Post updated successfully.");
          document.getElementById("edit-modal").classList.add("hidden");
          location.reload();
        } else {
          alert("Failed to update post: " + data.message);
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("An unexpected error occurred.");
      });
  });
});

// Open confirmation modal
function openConfirmModal(postId) {
  document.getElementById("confirm-modal").classList.remove("hidden");
}

// Close confirmation modal
function closeConfirmModal() {
  document.getElementById("confirm-modal").classList.add("hidden");
}

// Handle deletion with confirmation
function deletePostWithConfirmation(postId) {
  fetch(`delete-post.php?id=${postId}`, { method: "DELETE" })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        document.getElementById(`post-row-${postId}`).remove();
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
