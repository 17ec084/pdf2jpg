<?php

$im = new Imagick();
//�摜�𐶐�������PDF��ǂݍ���
$im->readImage('hoge.pdf');
//�y�[�W�����擾����
$totalPage = $im->getImageScene();

for ($i = 0; $i <= $totalPage; $i++) {
	//PDF�̃y�[�W
	$im->setImageIndex($i);
	//�T���l�C���T�C�Y 640px�Ɏ��߂�
	$im->thumbnailImage(640, 640, true);
	//�V���[�v
	$im->sharpenImage(0, 1);
	//����
	$im->writeImage('out_' . $i . '.jpg');
}

$im->destroy();

?>