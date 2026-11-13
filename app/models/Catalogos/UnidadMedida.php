
<?php

class UnidadMedida
{
    private PDO $conexion;

    public function __construct(PDO $conexion)
    {
        $this->conexion = $conexion;
    }

    public function obtenerTodas(): array
    {
        $sql = "SELECT
                    id_unidad,
                    nombre,
                    abreviatura
                FROM unidad_medida
                ORDER BY nombre ASC";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function registrar(
        string $nombre,
        string $abreviatura
    ): bool {

        $sql = "INSERT INTO unidad_medida
                    (nombre, abreviatura)
                VALUES
                    (:nombre, :abreviatura)";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            ":nombre" => $nombre,
            ":abreviatura" => $abreviatura
        ]);
    }

    public function obtenerPorId(int $id): array|false
    {
        $sql = "SELECT
                    id_unidad,
                    nombre,
                    abreviatura
                FROM unidad_medida
                WHERE id_unidad = :id";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([":id" => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar(
        int $id,
        string $nombre,
        string $abreviatura
    ): bool {

        $sql = "UPDATE unidad_medida
                SET nombre = :nombre,
                    abreviatura = :abreviatura
                WHERE id_unidad = :id";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            ":nombre" => $nombre,
            ":abreviatura" => $abreviatura,
            ":id" => $id
        ]);
    }

    public function existeNombre(
        string $nombre,
        ?int $excluirId = null
    ): bool {

        $sql = "SELECT COUNT(*)
                FROM unidad_medida
                WHERE nombre = :nombre";

        if ($excluirId !== null) {
            $sql .= " AND id_unidad <> :id";
        }

        $stmt = $this->conexion->prepare($sql);

        $parametros = [":nombre" => $nombre];

        if ($excluirId !== null) {
            $parametros[":id"] = $excluirId;
        }

        $stmt->execute($parametros);

        return (int)$stmt->fetchColumn() > 0;
    }

    public function existeAbreviatura(
        string $abreviatura,
        ?int $excluirId = null
    ): bool {

        $sql = "SELECT COUNT(*)
                FROM unidad_medida
                WHERE abreviatura = :abreviatura";

        if ($excluirId !== null) {
            $sql .= " AND id_unidad <> :id";
        }

        $stmt = $this->conexion->prepare($sql);

        $parametros = [":abreviatura" => $abreviatura];

        if ($excluirId !== null) {
            $parametros[":id"] = $excluirId;
        }

        $stmt->execute($parametros);

        return (int)$stmt->fetchColumn() > 0;
    }
}
