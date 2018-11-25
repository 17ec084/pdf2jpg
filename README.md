# pdf2jpg(phpによるファイル自動変換演習)

自主的に勉強しているものである。
## 1.目的
主にphpプログラミングの演習。  
また、GitHubでは他のユーザがレポジトリを見たとき、README.mdが表示される。  
mdファイル(MarkDown記法のテキストファイル)にはテキストの他、画像を挿入することができる。  
また、特に大学の授業のノートとしてリポジトリを公開している場合、他人に最も読んでもらいたいのはpdfファイルであったりすることも多い。  
そこで、pdfファイルをjpgファイルに変換して、画像としてREADME.mdに挿入するということを考えた。  
このプロセスを自動化するためのプログラムの作成を目的とする。
## 2.使用環境、ソフト
･[000webhost.com](https://www.000webhost.com/)がフリーで提供するサーバ  
･ImageMagick  
･Microsoft Word 2016

## 3.実験と結果
実験日: 2018/11/25
#### 3-1-1.実験1 拡張モジュールの確認 
①次のようなファイルtest.phpを作成し、サーバにアップロードした。[1]  

```php:3-1-1
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

②Microsoft Word 2016で「hoge.pdf」とだけ書いた文章hoge.pdfを作成した。  
③WWWブラウザで、サーバにアップロードしたtest.phpを閲覧した。  

#### 3-1-2.実験1の結果


<!--
[1]https://ameblo.jp/linking/entry-10997312536.html
-->
    