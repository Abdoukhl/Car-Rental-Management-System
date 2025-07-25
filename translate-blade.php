<?php

$viewsPath = __DIR__.'/resources/views';
$langDir = __DIR__.'/resources/lang/';
$langEn = $langDir . 'en/messages.php';
$langAr = $langDir . 'ar/messages.php';

$translations = [];

/**
 * ترجمة بسيطة إلى العربية (باستخدام ترجمة AI مؤقتة)
 */
function fakeTranslateToArabic($text) {
    // هذا الجزء يمكنك لاحقًا ربطه بـ API مثل DeepL أو ترجمة Google إذا رغبت
    return "ترجمة: " . $text;
}

function processFile($file) {
    global $translations;

    $content = file_get_contents($file);
    preg_match_all('/>([^<\n\r\t]+)</', $content, $matches);

    foreach ($matches[1] as $text) {
        $clean = trim($text);
        if (strlen($clean) > 0 && !preg_match('/\{\{|\@\w+/', $clean)) {
            $key = strtolower(str_replace([' ', '.', '?', '!', ',', ':', ';', '-'], '_', substr($clean, 0, 50)));
            if (!isset($translations[$key])) {
                $translations[$key] = $clean;
            }
            $content = str_replace(">$clean<", ">{{ __('messages.$key') }}<", $content);
        }
    }

    file_put_contents($file, $content);
}

function scanViews($dir) {
    $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($rii as $file) {
        if (!$file->isDir() && $file->getExtension() === 'php') {
            processFile($file->getPathname());
        }
    }
}

function writeLangFiles($enPath, $arPath, $translations) {
    if (!is_dir(dirname($enPath))) {
        mkdir(dirname($enPath), 0777, true);
    }

    file_put_contents($enPath, "<?php\n\nreturn [\n");
    file_put_contents($arPath, "<?php\n\nreturn [\n");

    foreach ($translations as $key => $val) {
        $ar = fakeTranslateToArabic($val); // ترجمة مؤقتة
        file_put_contents($enPath, "    '$key' => '$val',\n", FILE_APPEND);
        file_put_contents($arPath, "    '$key' => '$ar',\n", FILE_APPEND);
    }

    file_put_contents($enPath, "];\n", FILE_APPEND);
    file_put_contents($arPath, "];\n", FILE_APPEND);
}

// بدء التنفيذ
scanViews($viewsPath);
writeLangFiles($langEn, $langAr, $translations);

echo "✅ تمت معالجة جميع الصفحات. تحقق من ملفات الترجمة في resources/lang/en و ar\n";
