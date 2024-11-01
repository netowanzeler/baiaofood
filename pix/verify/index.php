<!DOCTYPE html>
<html>
<head>
    <title>Criar pagamento</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>
<body>

<h2>Criar um pagamento PIX</h2>

<form action="javascript: createPayment();">
    <label for="name">Nome:</label><br>
    <input type="text" id="name" name="name" required><br>
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br><br>
    <label for="value">Valor:</label><br>
    <input type="number" id="value" name="value" value="1.00" required><br><br>
    <input type="submit" value="Gerar pagamento">
</form>

<div class='paymentData' hidden>
    <h1>Dados para pagamento</h1>
    <img src="" id='qr_code_img' style='max-width:250px'><br>
    <input value="" id='qr_code_cp' style='max-width:250px'>
</div>

<div class="paymentApproved" hidden>
    <h1>Pagamento aprovado!</h1>
</div>

<script>
    function createPayment() {
        const body = {
            name: $("#name").val(),
            email: $("#email").val(),
            value: $("#value").val()
        };
        $.post("create/", body, (data) => {
            if (data.error) {
                alert("Erro ao gerar o pagamento: " + data.error);
                return;
            }
            document.getElementById("qr_code_img").src = "data:image/png;base64," + data.qr_code_base64;
            document.getElementById("qr_code_cp").value = data.qr_code;
            document.querySelector(".paymentData").hidden = false;
            const paymentReference = data.ref;
            checkPaymentInterval(paymentReference);
        });

        function checkPaymentInterval(ref) {
            setTimeout(() => {
                $.post("verify/", { ref: ref }, (data) => {
                    if (data.status === "approved") {
                        document.querySelector(".paymentData").hidden = true;
                        document.querySelector(".paymentApproved").hidden = false;
                    } else {
                        checkPaymentInterval(ref);
                    }
                });
            }, 10000); // Checa a cada 10 segundos
        }
    }
</script>

</body>
</html>
