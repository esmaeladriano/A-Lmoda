<!-- ------------ Testemunhos (Dinâmicos) --------------->
<div class="testimonial container justify-content-center">
    <div class="small-container">
        <div class="row">
            <?php
            // Conexão com banco
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "loja_online";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                echo '<p class="text-center w-100">Erro na conexão: ' . $conn->connect_error . '</p>';
            } else {
                // Consulta: pegar depoimento, nome do usuário e imagem, se houver
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
                        <div class="col teste mx-2">
                            <i class="fas fa-quote-left"></i>
                            <p>' . htmlspecialchars($row['depoimento']) . '</p>
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>';

                        // Verifica se o usuário tem imagem, senão usa imagem padrão
                        $imgPath = !empty($row['imagem']) ? 'uploads/' . $row['imagem'] : 'img/user-default.png';

                        echo '<img src="' . $imgPath . '" alt="User Image">
                            <h3>' . htmlspecialchars($row['nome']) . '</h3>
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
