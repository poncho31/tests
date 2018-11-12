from django.http import HttpResponse, Http404
from django.shortcuts import render, redirect
from testPython import views
from blog.models import Article

def home(request):
    return HttpResponse( """ 
        Id duis aliqua consectetur Lorem ad exercitation consequat ad do sit consequat commodo. 
        Ad cupidatat labore excepteur ipsum esse. 
        Occaecat aute ut minim veniam quis do velit excepteur id magna laborum.
    """)


def view_article(request, id_article):
    """
        Vue de l'article
    """
    if id_article > 100:
         raise Http404
    elif id_article > 90:
        return redirect("https://github.com/poncho31")
    elif id_article > 80:
        return redirect(views.view_redirection, id_article)
    else:
        return HttpResponse(
            "Vous avez demander l'article n° "+ str(id_article) +" !"
        )

def list_articles(request, id_article, year, month):
    """ Liste des articles d'un mois précis. """
    couleurs = ['rouge', 'orange', 'jaune', 'vert', 'bleu', 'indigo', 'violet']
    dicoCouleurs = {
        'FF0000': 'rouge',
        'ED7F10': 'orange',
        'FFFF00': 'jaune',
        '00FF00': 'vert',
        '0000FF': 'bleu',
        '4B0082': 'indigo',
        '660099': 'violet',
    }
    articles = Article.objects.all()

    return render(
        request,
        'blog/listArticles.html',
        locals()
    )
