<?php
namespace Drupal\drupalform\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class ExampleForm extends FormBase
{
    public function getFormId()
    {
        return 'drupalform_example_form';
    }

    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form['name'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Your Name'),
        ];
        $form['email_address'] = array(
            '#type' => 'email',
            '#title' => $this->t('Your Email Address')
        );
        $form['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Save'),
        ];
        return $form;
    }

    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        if (!$form_state->isValueEmpty('name')) {
            if (strlen($form_state->getValue('name')) <= 5) {
                $form_state->setErrorByName('name', t('Your Name error'));
            }
        }
        if (!filter_var($form_state->getValue('email_address', FILTER_VALIDATE_EMAIL))) {
            $form_state->setErrorByName('email_address', $this->t('The Email Address you have provided is invalid.'));
        }     
    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        drupal_set_message($this->t('Your Name is @name', array('@name' => $form_state->getValue('name'))));
        drupal_set_message($this->t('Your Email Address is @email', array('@email' => $form_state->getValue('email_address'))));
    }
}