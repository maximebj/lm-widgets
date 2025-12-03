# La Marketerie - Widgets

Plugin WordPress pour créer des widgets Elementor personnalisés avec système d'activation/désactivation.

## Description

Ce plugin permet de créer et gérer des widgets Elementor personnalisés. Il inclut une interface d'administration pour activer ou désactiver chaque widget individuellement.

## Installation

1. Téléchargez le plugin
2. Uploadez le dossier `lm-widgets` dans le répertoire `/wp-content/plugins/`
3. Activez le plugin via le menu 'Extensions' dans WordPress
4. Assurez-vous qu'Elementor est installé et activé

## Utilisation

### Page de réglages

1. Allez dans le menu "La Marketerie" dans l'administration WordPress
2. Cochez les widgets que vous souhaitez activer
3. Cliquez sur "Enregistrer les modifications"
4. Les widgets activés apparaîtront dans Elementor sous la catégorie "La Marketerie"

### Ajouter un nouveau widget

Pour ajouter un nouveau widget :

1. Créez un nouveau fichier dans le dossier `widgets/` (ex: `class-mon-widget.php`)
2. Créez une classe qui hérite de `\Elementor\Widget_Base`
3. Ajoutez le widget dans la méthode `get_available_widgets()` de la classe `LM_Widgets_Plugin`

## Widgets inclus

- **Widget Exemple 1** : Widget simple avec titre et description
- **Widget Exemple 2** : Widget avec bouton personnalisable

## Prérequis

- WordPress 5.0 ou supérieur
- PHP 7.4 ou supérieur
- Elementor 3.0.0 ou supérieur

## Support

Pour toute question ou problème, contactez La Marketerie.

## Changelog

### 1.0.0

- Version initiale
- Système d'activation/désactivation des widgets
- Deux widgets d'exemple
- Interface d'administration
