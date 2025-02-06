<h2>Confirmando tu cuenta...</h2>
<p id="message">Por favor, espera...</p>

<script>
    const token = localStorage.getItem("auth_token");

    if (!token) {
        document.getElementById("message").innerText = "No hay token disponible.";
    } else {
        fetch("http://localhost/proyecto/api/confirmAccount", {
            method: "POST",
            headers: {
                "Authorization": "Bearer " + token,
                "Content-Type": "application/json"
            }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById("message").innerText = data.message || data.error;
        })
        .catch(error => {
            document.getElementById("message").innerText = "Error en la confirmación.";
            console.error("Error:", error);
        });
    }
</script>
