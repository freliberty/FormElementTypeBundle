## Eliberty Configmanager

### Installation:

1. Declarer le bundle dans AppKernel.php

    new Eliberty\Bundle\FormElementTypeBundle\ElibertyFormElementTypeBundle()
2.

3. Generer les entités

    sf doctrine:schema:update --force


### Utilisation

Les services sont accessible de puis n'import ou dans votre projet

Specifier les champs de formulaire dans votre formulaire

champs de formulaire disponible:

    - eliberty_boolean
         - permet un masque de saisie au format boolean

            exemple:  ->add(nom du champs, 'eliberty_boolean')

    - eliberty_datetime_picker
        - permet un masque de saisie au format datetime (dd-mm-yyyy h:m:s)
            - exemple : ->add('birthdate', eliberty_datetime_picker);
    - eliberty_datepicker
        - permet un masque de saisie au format datetime (dd-mm-yyyy)
            - exemple : ->add('birthdate', 'eliberty_datepicker', [
                                                                        'horizontal'                     => false,
                                                                        'widget'                         => 'single_text',
                                                                        'format'                         => 'dd/MM/yyyy',
                                                                        'input'                          => 'datetime',
                                                                        'attr'                           => ['placeholder' => 'rp.forms.global.dateformat'],
                                                                    ])

    - eliberty_multiselect
        - champs de formulaire avec un multiselect

            - exemple:  ->add('rights', 'eliberty_multiselect', 'attr'
                                                            => ['class' => 'input-xlarge', 'position' => 'right',  'disableLabel' => true],
                                                                    'class'                          => 'RedpillBundle:Right',
                                                                    'property'                       => 'shortname',
                                                                    'multiple'                       => true,
                                                                    'required'                       => false])



    - eliberty_markdown_editor
         - permet un masque de saisie au format markdown
            - exemple : ->add('longdesc', 'rp_markdown_editor',['attr' => ['clone_path' => 'product']])
    - eliberty_expanded
        - remplace les radios bouton avec css personaliser
            - exemple : ->add('gender', 'eliberty_expanded', ['choices'  => ['M' => 'Masculin', 'F' => 'Féminin'],
                                                                   'expanded' => true,
                                                                   'multiple' => false])
    - eliberty_bnt_choice
        - permet de crée un champs de formulaire avec un select de type button
            - exemple : ->add('status' , 'eliberty_bnt_choice', ['choice_list'       => new SimpleChoiceList($typesChoices),
                                                                      'preferred_choices' => [Contactstatus::NONE],
                                                                      'label'             => 'config.manager.page.configuration.type',
                                                                      'attr'              => [
                                                                          'max_selected_options' => '1',
                                                                          'position'             => 'right',
                                                                          'fieldset'             => 'rp.console.contact.status',
                                                                          'disableLabel'         => true,
                                                                          'setStyle'             => true,
                                                                          'danger'               => 'terminated',
                                                                          'info'                 => 'torenew',
                                                                          'warning'              => 'pending',
                                                                      ])
    - eliberty_json
        - permet un masque de saisie au format json

    - eliberty_integer
        - permet un masque de saisie au format integer

    - eliberty_decimal
        - Permet un masque de saisie au format decimal

    - eliberty_entity_hidden
        - champs de formulaire de type hidden qui contient une entity
            - exemple : ->add('contractor', 'eliberty_chosen_entity', array(
                                            'class' => 'RedpillBundle:Contractor',
                                            'multiple'=> false,
                                            'property'=> 'name',
                                            'empty_value' => 'select a contractor',
                                            'required' => false,
                                            'attr' => [
                                                'class' => 'col-xs-12',
                                                'max_selected_options' => '1'
                                            ]
                                        ))

    - eliberty_polycollection
        - champs de formulaire de type collection

    - eliberty_chosen
        - champs de formulaire de type select avec recherche
            - exemple : ->add('roles', 'eliberty_chosen', array(
                                                'choices' => array(
                                                    'ROLE_NET_CUSTOMER' => 'Customer',
                                                    'ROLE_NET_CONTRACTOR' => 'Contractor',
                                                    'ROLE_PARTNER' => 'Partner',
                                                    'ROLE_ADMIN' => 'Administrator',
                                                    'ROLE_SUPER_ADMIN' => 'Super Administrator'),
                                                'multiple' => true,
                                                'empty_value' => 'Select a role',
                                                'attr' => [
                                                    'class' => 'col-xs-12',
                                                ]
                                            ))

    - eliberty_chosen_entity
        - champs de formulaire de type select avec recherche pour les entités
            - exemple :  ->add('partners', 'eliberty_chosen_entity', array(
                                        'class' => 'RedpillBundle:Partner',
                                        'multiple'=> false,
                                        'property'=> 'name',
                                        'empty_value' => 'select partenaires',
                                        'required' => false,
                                        'attr' => [
                                            'class' => 'col-xs-12',
                                            'max_selected_options' => '1'
                                        ]
                                    ))


### Modes de fonctionnement

deux type d'implementations disponibles en definisant la clef dans le fichier config.yml :

1. implementer dans redpill

    twig:
        globals:
            formelementtypemode: redpill

2. implementation seul

   il faut generer les dependence js et css

   - cd vendor/eliberty/formelementtype-bundle/Eliberty/Bundle/FormElementTypeBundle/
   - bower install






