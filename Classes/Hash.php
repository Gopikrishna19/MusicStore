<?php 
    class Hash
    {
        public static function digest($data)
        {
            $context = hash_init("md5", HASH_HMAC, MS_SALT);
            hash_update($context, $data);

            return hash_final($context);
        }
    }
?>