<?php

namespace App\Form;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class GadoType extends AbstractType
{
		
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('codigo', IntegerType::class, [
				'label' => 'Código do gado: ',
				'attr' => ['placeholder' => 'Codigo']
			])
			->add('leite', NumberType::class, [
				'label' => 'Leite por semana: ', 
				'attr' => ['placeholder' => 'Litros de leite produzido na semana'],
				'invalid_message' => 'Insira um número válido'
			])
			->add('racao', NumberType::class, [
				'label' => 'Ração ingerida por semana: ',
				'attr' => ['placeholder' => 'Ração em quilos ingerida por semana'],
				'invalid_message' => 'Insira um número válido'
			])
			->add('peso', NumberType::class, [
				'label' => 'Peso do Gado em quilos: ', 
				'attr' => ['placeholder' => 'Peso do gado em quilos'],
				'invalid_message' => 'Insira um número válido'
			])
			->add('nascimento', DateType::class, [
				'label' => 'Data de nascimento do gado',
				'html5' => false,
				'format' => 'dd/MM/yyyy',
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker', 'placeholder' => 'dia/mes/ano'],
                'constraints' => [
                	new Assert\LessThanOrEqual([
                		'value' => 'today',
                		'message' => 'A data não pode ser futura'
                	])
                ]
			])
			->add('Salvar', SubmitType::class);
	}

}