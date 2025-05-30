<!-- ------------ Testemunhos (Dinâmicos) --------------->
<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
.testimonial1-card {
    animation: fadeIn 1s;
    background: #dcdcdc;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.07);
    padding: 24px 18px;
    margin: 16px auto;
    min-width: 300px;
    max-width: 350px;
    min-height: 220px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    word-break: break-word;
}
.testimonial1-card p {
    font-size: 1.05rem;
    margin-bottom: 16px;
    text-align: center;
}
</style>

<div class="testimonial1 container justify-content-center"  style="margin-top: 5rem">
    <h2 class="text-center mb-4">💬 O que nossos clientes dizem</h2>
    <div class="small-container">
        <div class="row justify-content-center">
            <?php
            // Conexão com banco
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "loja_online";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                echo "<p class=\"text-center w-100\">Erro na conexão: {$conn->connect_error}</p>";
            } else {
                // Consulta: pegar depoimento, nome do usuário e data
                $sql = "
                    SELECT d.depoimento, d.data_depoimento, u.nome
                    FROM depoimentos d
                    INNER JOIN usuarios u ON d.usuario_id = u.id
                    ORDER BY d.data_depoimento DESC
                    LIMIT 3
                ";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '
                        <div class="col-md-4 d-flex justify-content-center">
                            <div class="testimonial1-card">
                                <i class="fas fa-quote-left mb-2" style="color:#f39c12;font-size:1.5rem;"></i>
                                <p>' . htmlspecialchars($row['depoimento']) . '</p>
                                <div class="rating mb-2">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                <h3 class="mb-0" style="font-size:1.1rem;">' . htmlspecialchars($row['nome']) . '</h3>
                            </div>
                        </div>';
                    }
                } else {
                    echo '<p class="text-center w-100">Nenhum depoimento encontrado.</p>';
                }

                $conn->close();
            }
            ?>
        </div>
    </div>
</div>
