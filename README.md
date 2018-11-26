# pdf2jpg(phpによるファイル自動変換演習(2回目の挑戦、失敗))

自主的に勉強しているものである。
## 1.目的
主にphpプログラミングの演習。  
また、GitHubでは他のユーザがレポジトリを見たとき、README.mdが表示される。  
mdファイル(MarkDown記法のテキストファイル)にはテキストの他、画像を挿入することができる。  
また、特に大学の授業のノートとしてリポジトリを公開している場合、他人に最も読んでもらいたいのはpdfファイルであったりすることも多い。  
そこで、pdfファイルをjpgファイルに変換して、画像としてREADME.mdに挿入するということを考えた。  
このプロセスを自動化するためのプログラムの作成を目的とする。
## 2.使用環境、ソフト
･Windows 10 Pro  
･[xampp (PHP 7.2.12)](https://www.apachefriends.org/jp/index.html) (Control Panelのバージョンはv3.2.2であった)  
･[ImageMagick-7.0.7-11-vc15-x86](https://windows.php.net/downloads/pecl/deps/ImageMagick-7.0.7-11-vc15-x86.zip)  
･[php_imagick-3.4.3-7.2-ts-vc15-x86](https://windows.php.net/downloads/pecl/snaps/imagick/3.4.3/php_imagick-3.4.3-7.2-ts-vc15-x86.zip)  
･[Ghostscript 9.26 for Windows (32 bit) AGPL licence](https://github.com/ArtifexSoftware/ghostpdl-downloads/releases/download/gs926/gs926w32.exe)  
･Microsoft Word 2016

## 3.実験と結果
実験日: 2018/11/25
#### 3-1-1.実験1 端末のサーバ化[1]
①参考サイト[1]に従ってXAMPPをインストールした。  
但し、すべてのソフトを選択してインストールした。  
また、xamppをインストールしたディレクトリは`c:\xampp`である。
②http\://localhost/ にアクセスした。
#### 3-1-2.実験1の結果
図3-1-2のようなページが表示された。  
![図3-1-2](https://raw.githubusercontent.com/17ec084/pdf2jpg/secondChallenge/data/3_1_2.png "図3-1-2")  
<Div Align="center">図3-1-2 実験1の結果</Div>  

#### 3-2-1 実験2 拡張モジュールの確認
①次のようなファイルtest.php[2]を作成し、`C:\xampp\htdocs`にコピーした。このディレクトリにコピーすることは、サーバへのアップロードに相当する。  

```php:3-2-1
<?php

$im = new Imagick();
//画像を生成したいPDFを読み込む
$im->readImage('hoge.pdf');
//ページ数を取得する
$totalPage = $im->getImageScene();

for ($i = 0; $i <= $totalPage; $i++) {
	//PDFのページ
	$im->setImageIndex($i);
	//サムネイルサイズ 640pxに収める
	$im->thumbnailImage(640, 640, true);
	//シャープ
	$im->sharpenImage(0, 1);
	//生成
	$im->writeImage('out_' . $i . '.jpg');
}

$im->destroy();

?>

```


②Microsoft Word 2016で「hoge.pdf」とだけ書いた文章hoge.pdfを作成し、`C:\xampp\htdocs`にコピーした。  
③WWWブラウザで、サーバにアップロードしたtest.phpを閲覧した。  

#### 3-2-2.実験2の結果
実験2の結果、次のようにFatal errorが表示された。

> <br />
> <b>Fatal error</b>:  Uncaught Error: Class 'Imagick' not found in C:\xampp\htdocs\test.php:3
> Stack trace:
> #0 {main}
>   thrown in <b>C:\xampp\htdocs\test.php</b> on line <b>3</b><br />

このことから、xamppによって作られたサーバにはImageckというクラスが用意されていない、即ちImageMagickがインストールされていないということが分かった。



#### 3-3-1.実験3 ImageMagickを利用可能可[2]
①次のようなisTs.php[3]を作成し、`c:\xampp\htdocs` にコピーし、 http\://localhost/isTs.php にアクセスし、  
･php versionを確認した。  
･Compiler versionを確認した。  
･Architectureを確認した。  
･thread safeが有効か否かを確認した。  

```php:3-3-1
<?php
print phpinfo();
?>
```
②GhostScriptを`C:\xampp\gs\gs9.26`にインストールした。  
③ImageMagickの公式ダウンロードページにアクセスし、ImageMagick-7.0.7-11-vc15-x86.zip をダウンロードした。  
vc15はxamppに入っているphpのコンパイラのバージョンであり、x86は、xamppに入っているソフトはみな32 bitで動作するものであるからである。(表3-3-2-1を確認されたい)  
そして展開し、中身を`c:\xampp\ImageMagick`にすべてコピーした。  
④Imagickの公式ダウンロードページにアクセスし、`3.4.3` ディレクトリを選択し、`php_imagick-3.4.3-7.2-ts-vc15-x86.zip` を探した。  
7.2は、phpのバージョンが7.2.nであることを、tsはthread safeが有効であること、vc15はコンパイラのバージョン、x86は32 bitを意味する。  
表3-3-2-1と対応させて正しい名前のzipファイルを選ばないと、実験が正常に行えない。  
参考サイト[2]に示されたダウンロードページに`php_imagick-3.4.3-7.2-ts-vc15-x86.zip`は存在しなかった。しかし、別のページ[4]には存在したので、それをダウンロードした。  
展開後`php_imagick.dll` を`C:\xampp\php\ext `へコピーし、  
`CORE_RL_` で始まるファイルをすべて`C:\xampp\ImageMagick\bin\` に上書きコピーした。  
⑤`C:\xampp\php\php.ini` の  

> ;;;;;;;;;;;;;;;;;;;;;;  
> ; Dynamic Extensions ;  
> ;;;;;;;;;;;;;;;;;;;;;;  

のところに`extension=` が並んでいるところがあるので、そこに`extension=php_imagick.dll` を加筆した。  
⑥図3-3-1のように環境変数を指定した。
<Div Align="center">

![図3-3-1](https://raw.githubusercontent.com/17ec084/pdf2jpg/secondChallenge/data/3_3_1.png "図3-3-1")  

図3-3-1 環境変数の設定

</Div>  

#### 3-3-2.実験3の結果
①の結果、表3-3-2-1のようなことが分かった。  

<Div Align="center">表3-3-2-1 インストールされたphpの仕様</Div>

| PHP Version   | 7.2.12                   |
|:--------------|:-------------------------|
| Compiler      | MSVC15 (Visual C++ 2017) |
| Architecture  | x86                      |
| Thread Safety | enabled                  |

②～⑥をしたうえで`http://localhost/isTs.php` にアクセスした結果、①の段階では表示されなかった、表3-3-2-2が表示された。  

<Div Align="center">表3-3-2-2 phpinfo()が出力した、imagickの詳細</Div>

| imagick module                            | enabled                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              |
|-------------------------------------------|----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| imagick module version                    | @PACKAGE_VERSION@                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    |
| imagick classes                           | Imagick, ImagickDraw, ImagickPixel, ImagickPixelIterator, ImagickKernel                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              |
| Imagick compiled with ImageMagick version | ImageMagick 7.0.7-11 Q16 x86 2017-11-23 http://www.imagemagick.org                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   |
| Imagick using ImageMagick library version | ImageMagick 7.0.7-11 Q16 x86 2017-11-23 http://www.imagemagick.org                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   |
| ImageMagick copyright                     | Copyright (C) 1999-2015 ImageMagick Studio LLC                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       |
| ImageMagick release date                  | 2017/11/23                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           |
| ImageMagick number of supported formats:  | 238                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  |
| ImageMagick supported formats             | 3FR, 3G2, 3GP, AAI, AI, ART, ARW, AVI, AVS, BGR, BGRA, BGRO, BIE, BMP, BMP2, BMP3, BRF, CAL, CALS, CANVAS, CAPTION, CIN, CIP, CLIP, CLIPBOARD, CMYK, CMYKA, CR2, CRW, CUR, CUT, DCM, DCR, DCX, DDS, DFONT, DJVU, DNG, DOT, DPS, DPX, DXT1, DXT5, EMF, EPDF, EPI, EPS, EPS2, EPS3, EPSF, EPSI, EPT, EPT2, EPT3, ERF, EXR, FAX, FILE, FITS, FLIF, FPX, FRACTAL, FTP, FTS, G3, G4, GIF, GIF87, GRADIENT, GRAY, GROUP4, GV, HALD, HDR, HISTOGRAM, HRZ, HTM, HTML, HTTP, HTTPS, ICB, ICO, ICON, IIQ, INFO, INLINE, IPL, ISOBRL, ISOBRL6, J2C, J2K, JBG, JBIG, JNG, JNX, JP2, JPC, JPE, JPEG, JPG, JPM, JPS, JPT, JSON, K25, KDC, LABEL, M2V, M4V, MAC, MAP, MASK, MAT, MATTE, MEF, MIFF, MKV, MNG, MONO, MOV, MP4, MPC, MPEG, MPG, MRW, MSL, MSVG, MTV, MVG, NEF, NRW, NULL, ORF, OTB, OTF, PAL, PALM, PAM, PANGO, PATTERN, PBM, PCD, PCDS, PCL, PCT, PCX, PDB, PDF, PDFA, PEF, PES, PFA, PFB, PFM, PGM, PICON, PICT, PIX, PJPEG, PLASMA, PNG, PNG00, PNG24, PNG32, PNG48, PNG64, PNG8, PNM, PPM, PS, PS2, PS3, PSB, PSD, PTIF, PWP, RADIAL-GRADIENT, RAF, RAS, RAW, RGB, RGBA, RGBO, RGF, RLA, RLE, RMF, RW2, SCR, SCREENSHOT, SCT, SFW, SGI, SHTML, SIX, SIXEL, SPARSE-COLOR, SR2, SRF, STEGANO, SUN, SVG, SVGZ, TEXT, TGA, THUMBNAIL, TIFF, TIFF64, TILE, TIM, TTC, TTF, TXT, UBRL, UBRL6, UIL, UYVY, VDA, VICAR, VID, VIFF, VIPS, VST, WBMP, WEBP, WMF, WMV, WPG, X3F, XBM, XC, XCF, XPM, XPS, XV, YCbCr, YCbCrA, YUV |

これは、ImageMagickのモジュールが正常に読み込まれたことを意味する。  

そして`http://localhost/test.php` にアクセスすると、

> <br />
> <b>Fatal error</b>:  Uncaught ImagickException: UnableToOpenBlob 'hoge.pdf': No such file or directory @ error/blob.c/OpenBlob/3315 > in C:\xampp\htdocs\test.php:5
> Stack trace:
> #0 C:\xampp\htdocs\test.php(5): Imagick-&gt;readimage('hoge.pdf')
> #1 {main}
>   thrown in <b>C:\xampp\htdocs\test.php</b> on line <b>5</b><br />

のように表示され、エラーの内容が実験2のときとは異なるものとなった。  
このことにより、phpプログラム自体は書き直さなくてはいけないが、モジュール自体は動作しているということが改めて確認された。

#### 3-4 実験4 phpファイルの読み込み とその結果
ImageMagickをphpで動かし、pdfファイルを読み込むことのできるphpプログラムのコードがネットのどこかに落ちていないか探した。  
しかし、どの関数を使ってpdfファイルやjpgファイルを読み込む実験をしても、file_get_contents()の出力を読み込んでも、エラーを返すばかりであった。  

## 4.反省
参考サイト[5][6]によると、ImageMagickをダウンロードしたら、適切な方法でコンパイルしてconfigure.exeなるファイルを作る必要があり、しかも今回インストールしたImageMagick7ではだめで、バージョン6で行わないといけないようである。   
次回再挑戦する場合は、ImageMagick6をインストールすることにする。  
但し、この変更により、現状がさらに悪化して、なおかつ復旧不可能になるようではもったいないので、[C:\xampp\ImageMagick]()をGitHubに保管、公開しておくことにする。  

## 5.参考サイト
[1]http://www.kent-web.com/www/chap1.html  
[2]https://qiita.com/_xider/items/73c29d79eb4e252e64f7  
[3]https://mumu.jpn.ph/forest/computer/2017/03/19/8093/  
[4]https://windows.php.net/downloads/pecl/snaps/imagick/3.4.3/  
[5]https://oxynotes.com/?p=10474  
[6]https://qiita.com/tsukachin999/items/f955b77095ec8502ab9b 
    
