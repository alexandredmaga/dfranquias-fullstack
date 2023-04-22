<?php

namespace App\Form;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class GadoType extends AbstractType
{
		
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('codigo', TextType::class, [
				'label' => 'Código do gado: ',
				'attr' => ['placeholder' => 'Codigo']
			])
			->add('leite', TextType::class, [
				'label' => 'Leite por semana: ', 
				'attr' => ['placeholder' => 'Litros de leite produzido na semana']
			])
			->add('racao', TextType::class, [
				'label' => 'Ração ingerida por semana: ',
				'attr' => ['placeholder' => 'Ração em quilos ingerida por semana']
			])
			->add('peso', TextType::class, [
				'label' => 'Peso do Gado em quilos: ', 
				'attr' => ['placeholder' => 'Peso do gado em quilos']
			])
			->add('nascimento', DateType::class, [
				'label' => 'Data de nascimento do gado',
				'html5' => false,
				'format' => 'dd/MM/yyyy',
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker', 'placeholder' => 'dia/mes/ano']
			])
			->add('Salvar', SubmitType::class);
	}

}