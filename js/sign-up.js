$(document).ready(function () {
	// Handle the form submission
	$("#sign-up-form").on("submit", function (e) {
		e.preventDefault();

		// Clear previous messages
		$("#error-message").hide("slow").text("");
		$("#success-message").hide("slow").text("");

		// Gather form data
		let username = $("#username").val().trim();
		let email = $("#email").val().trim();
		let password = $("#password").val().trim();
		let confirmPassword = $("#confirm-password").val().trim();

		// Validate inputs (additional client-side validation)
		if (!username || !email || !password || !confirmPassword) {
			$("#error-message").text("All fields are required").show("slow");
			return;
		}

		if (password.length < 6) {
			$("#error-message")
				.text("Password must be at least 6 characters long")
				.show("slow");
			return;
		}

		if (password !== confirmPassword) {
			$("#error-message").text("Passwords do not match").show("slow");
			return;
		}

		// Form data
		let formData = {
			username: username,
			email: email,
			password: password,
			confirmPassword: confirmPassword
		};

		// AJAX request
		$.ajax({
			url: "ajax/sign-up.php",
			method: "POST",
			data: formData,
			beforeSend: function () {
				// Show spinner and adjust opacity
				$(".card").css("opacity", "0.5");
				$(".spinner-overlay").show("slow");
				$("#sign-up-btn").html("Loading ...").prop("disabled", true);
			},
			success: function (response) {
				console.log("Response:", response); // Log response for debugging
				try {
					var jsonResponse = JSON.parse(response);
					if (jsonResponse.success) {
						$("#success-message")
							.text(jsonResponse.message)
							.show("slow");
						$("#sign-up-form").trigger("reset");
						$("#error-message").hide("slow");
					} else {
						$("#error-message")
							.text(jsonResponse.message)
							.show("slow");
						$("#success-message").hide("slow");
					}
				} catch (e) {
					console.log(e);
					$("#error-message").html(response).show("slow"); // Display raw response for debugging
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(textStatus);
				$("#error-message")
					.text("An error occurred: " + textStatus)
					.show("slow");
				$("#success-message").hide("slow");
			},
			complete: function () {
				// Hide spinner and restore opacity
				$(".card").css("opacity", "1");
				$(".spinner-overlay").hide("slow");
				$("#sign-up-btn").html("Sign Up").prop("disabled", false);
			}
		});
	});
});
