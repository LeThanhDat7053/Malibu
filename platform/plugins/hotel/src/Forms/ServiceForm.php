<?php

namespace Botble\Hotel\Forms;

use Botble\Base\Forms\FieldOptions\ContentFieldOption;
use Botble\Base\Forms\FieldOptions\DescriptionFieldOption;
use Botble\Base\Forms\FieldOptions\NameFieldOption;
use Botble\Base\Forms\FieldOptions\StatusFieldOption;
use Botble\Base\Forms\Fields\EditorField;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
use Botble\Hotel\Http\Requests\ServiceRequest;
use Botble\Hotel\Models\Service;

class ServiceForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->setupModel(new Service())
            ->setValidatorClass(ServiceRequest::class)
            ->withCustomFields()
            ->add('name', TextField::class, NameFieldOption::make()->required()->toArray())
            ->add('custom_url', 'text', [
                'label' => 'Custom URL',
                'attr' => [
                    'placeholder' => 'https://example.com/page — Để trống sẽ dùng link mặc định',
                    'class' => 'form-control',
                ],
                'help_block' => [
                    'text' => 'Nhập URL tùy chỉnh nếu muốn Service này trỏ sang link khác. Để trống sẽ dùng link mặc định (/services/slug).',
                ],
            ])
            ->add('description', TextareaField::class, DescriptionFieldOption::make()->toArray())
            ->add('content', EditorField::class, ContentFieldOption::make()->toArray())
            ->add('status', SelectField::class, StatusFieldOption::make()->toArray())
            ->add('image', MediaImageField::class)
            ->setBreakFieldPoint('status');
    }
}
