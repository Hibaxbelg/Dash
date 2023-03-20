<script>
    function SendRequest(e, url, redirectUrl) {
        e.preventDefault();

        let form = e.target;
        let submitBtn = form.querySelector("button[type='submit']");
        let errorDiv = form.querySelector(".errors");

        errorDiv.innerHTML = '';
        submitBtn.disabled = true;

        let inputs = form.querySelectorAll('input, select, textarea');

        const formData = {};
        inputs.forEach(input => {
            const name = input.getAttribute('name');
            const value = input.value;
            formData[name] = value;
        });

        console.log(inputs);

        axios.post(url, formData).then(function(e) {
            window.location.href = redirectUrl;
        }).catch(function(e) {
            response = e.response.data.errors;
            let errors = [];
            for (let key in response) {
                errors.push([key][0]);
            }
            errors.forEach(function(error) {
                let div = document.createElement("div");
                div.classList.add("alert", "alert-danger");
                div.innerHTML = response[error];
                errorDiv.appendChild(div);
            })
        }).finally(function() {
            submitBtn.disabled = false;
        })
    }
</script>