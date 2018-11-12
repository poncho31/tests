from django import forms
from blog.models import Article


class ContactForm(forms.Form):
    sujet = forms.CharField(max_length=100)
    message = forms.CharField(widget=forms.Textarea)
    envoyeur = forms.EmailField(label="Votre adresse e-mail")

    def clean(self):
        cleaned_data = super(ContactForm, self).clean()
        sujet = cleaned_data.get('sujet')
        message = cleaned_data.get('message')

        if sujet and message:  # Est-ce que sujet et message sont valides ?
            if "pizza" in sujet and "pizza" in message:
                raise forms.ValidationError(
                    "Vous parlez de pizzas dans le sujet ET le message ? Non mais ho !"
                )

        return cleaned_data  # N'oublions pas de renvoyer les données si tout est OK

    renvoi = forms.BooleanField(
        help_text="Cochez si vous souhaitez obtenir une copie du mail envoyé.", required=False)


class ArticleForm(forms.ModelForm):
    class Meta:
        model = Article
        fields = '__all__'
