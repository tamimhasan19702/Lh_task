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

function openEditModal(postId) {
  currentPostId = postId;

  fetch(`edit-post.php?id=${postId}`)
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        document.getElementById("post-id").value = data.post.id;
        document.getElementById("edit-title").value = data.post.title;
        document.getElementById("edit-description").value =
          data.post.description;

        document.getElementById("edit-modal").classList.remove("hidden");
      } else {
        alert("Failed to load post: " + data.message);
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
