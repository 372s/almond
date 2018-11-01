<?php

echo filter_input(INPUT_GET, 'text', FILTER_SANITIZE_STRING);die;
echo filter_input(INPUT_GET, 'text', FILTER_VALIDATE_URL);die;
echo filter_input(INPUT_GET, 'text', FILTER_VALIDATE_EMAIL);die;
echo filter_input(INPUT_GET, 'text', FILTER_SANITIZE_EMAIL);die;
