
<?php

class Categoria
{
    private PDO $conexion;

    public function __construct(PDO $conexion)
    {
        $this->conexion = $conexion;
    }

    public function obtenerTodas(): array
    {
        $sql = "SELECT
                    id_categoria,
                    nombre,
                    descripcion,
                    estado
                FROM categoria_item
                ORDER BY nombre ASC";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function registrar(
        string $nombre,
        ?string $descripcion
    ): bool {

        $sql = "INSERT INTO categoria_item
                    (nombre, descripcion)
                VALUES
                    (:nombre, :descripcion)";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            ":nombre" => $nombre,
            ":descripcion" => $descripcion
        ]);
    }

    public function obtenerPorId(int $id): array|false
    {
        $sql = "SELECT
                    id_categoria,
                    nombre,
                    descripcion,
                    estado
                FROM categoria_item
                WHERE id_categoria = :id";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([":id" => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar(
        int $id,
        string $nombre,
        ?string $descripcion
    ): bool {

        $sql = "UPDATE categoria_item
                SET nombre = :nombre,
                    descripcion = :descripcion
                WHERE id_categoria = :id";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            ":nombre" => $nombre,
            ":descripcion" => $descripcion,
            ":id" => $id
        ]);
    }

    public function cambiarEstado(int $id, int $estado): bool
    {
        $sql = "UPDATE categoria_item
                SET estado = :estado
                WHERE id_categoria = :id";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            ":estado" => $estado,
            ":id" => $id
        ]);
    }

    public function existeNombre(
        string $nombre,
        ?int $excluirId = null
    ): bool {

        $sql = "SELECT COUNT(*)
                FROM categoria_item
                WHERE nombre = :nombre";

        if ($excluirId !== null) {
            $sql .= " AND id_categoria <> :id";
        }

        $stmt = $this->conexion->prepare($sql);

        $parametros = [":nombre" => $nombre];

        if ($excluirId !== null) {
            $parametros[":id"] = $excluirId;
        }

        $stmt->execute($parametros);

        return (int)$stmt->fetchColumn() > 0;
    }
}
