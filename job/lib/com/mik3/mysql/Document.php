<?php

namespace com\3mik\mysql {

    use com\indigloo\common\mysql as MySQL;

    class Document {
        const MODULE_NAME = 'webgloo\job\mysql\Document';

        static function create($document) {

            $mysqli = MySQL\Connection::getInstance()->getHandle();

            $sql = " insert into job_document(store_name, original_name,mime,size,created_on,entity_id,entity_name)";
            $sql .= " values(?,?,?,?,now(),?,? ) ";

            $code = MySQL\Connection::ACK_OK;

            $stmt = $mysqli->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("sssiis",
                        $document->storeName,
                        $document->originalName,
                        $document->mime,
                        $document->size,
                        $document->entityId,
                        $document->entityName);

                $stmt->execute();

                if ($mysqli->affected_rows != 1) {
                    $code = MySQL\Error::handle(self::MODULE_NAME, $stmt);
                }
                $stmt->close();
            } else {
                $code = MySQL\Error::handle(self::MODULE_NAME, $mysqli);
            }

            //if no one has raised an error
            if ($code == MySQL\Connection::ACK_OK) {
                //get last insert id
                $lastInsertId = MySQL\Connection::getInstance()->getLastInsertId();
            }

            return array('code' => $code, 'lastInsertId' => $lastInsertId);
        }

    }

}
?>
