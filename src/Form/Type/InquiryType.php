<?php
namespace App\Form\Type;

use App\Entity\Inquiry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InquiryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'form.field.label.email',
                'required' => true,
                'attr' => [
                    'placeholder' => 'form.field.placeholder.email'
                ],
            ])
            ->add('name', TextType::class, [
                'label' => 'form.field.label.name',
                'label_html' => true,
                'required' => false,
                'empty_data' => '', // Because the form field is optional but teh database field is not null able.
                'attr' => [
                    'placeholder' => 'form.field.placeholder.name'
                ],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'form.field.label.message',
                'required' => true,
                'attr' => [
                    'style' => 'min-height: 10rem',
                    'placeholder' => 'form.field.placeholder.message'
                ],
            ])
            ->add('acceptDataPrivacy', CheckboxType::class, [
                'label' => 'form.field.label.acceptDataPrivacy',
                'label_html' => true,
                'required' => true,
            ])
            // The field sendCopyToReceiver is the honeypot.
            ->add('sendCopyToReceiver', HiddenType::class, [
                "mapped" => false,
            ])
//            ->add('captcha', CaptchaType::class, [
//                'width' => 240,
//                'height' => 80,
//            ])
            ->add('submit', SubmitType::class, [
                'label' => 'form.field.label.submit',
                'attr' => [
                    'class' => 'btn-custom btn-xl'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Inquiry::class]);
    }
}