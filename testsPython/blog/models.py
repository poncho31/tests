from django.db import models
from django.utils import timezone
from django import forms


class Article(models.Model):
    titre = models.CharField(max_length=100)
    auteur = models.CharField(max_length=50)
    contenu = models.TextField(null=True)
    date = models.DateTimeField(default=timezone.now, verbose_name="Date de parution")
    categorie = models.ForeignKey('Categorie', on_delete=models.CASCADE)

    class Meta:
        verbose_name = "article"
        ordering = ['date']

    def __str__(self):
        """ 

        Cette méthode que nous définirons dans tous les modèles
        nous permettra de reconnaître facilement les différents objets que
        nous traiterons plus tard dans l'administration

        """
        return self.titre

        # 
        # CLI: python manage.py shell
        # >>> from blog.models import Article
        # >>> article = Article(titre="Bonjour", auteur="Maxime")
        # >>> article.contenu = "Les crêpes bretonnes sont trop bonnes !"
        # >>> article.save()
        # >>> Article.objects.all()
        # <QuerySet[] >
        # python manage.py makemigrations 
        # python manage.py migrate


class Categorie(models.Model):
    nom = models.CharField(max_length=30)

    def __str__(self):
        return self.nom