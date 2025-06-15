from django.urls import path, include
from . import views

urlpatterns = [
    # Páginas principales
    path('', views.index, name='index'),
    path('login_register/', views.login_register, name='login_register'),
    path('register/', views.register_view, name='register'),
    path('login/', views.login_view, name='login'),        
    path('logout/', views.logout_view, name='logout'),
    path('perfil/', views.profile_view, name='profile'),
    path('faq/', views.faq, name='faq'),
    path('contacto/', views.contacto, name='contacto'),
    path('recuperacion/', views.recuperacion, name='recuperacion'),
    path('mapa_sitio/', views.mapa_sitio, name='mapa_sitio'),
    path('captcha_gate/', views.captcha_gate, name='captcha_gate'),
    # path('captcha_gate/', views.captcha_gate, name='captcha_gate'),  # Comentado porque no existe la vista

    # Mensajes
    path('mensajes/', views.message_list, name='message_list'),
    path('mensajes/<int:user_id>/', views.messages_with_user, name='messages_with_user'),
    path('mensajes/<int:message_id>/eliminar/', views.delete_message, name='delete_message'),

    # Amigos
    path('amigos/', views.amigos, name='amigos'),
    path('amigos/add/', views.add_friend, name='add_friend'),
    path('amigos/remove/<int:user_id>/', views.remove_friend, name='remove_friend'),
    path('amigos/send_message/<int:user_id>/', views.send_message, name='send_message'),
    path('accept_request/<int:request_id>/', views.accept_request, name='accept_request'),

    # Otros
    path('bosserver/', views.bosserver, name='bosserver'),

    # 👇 Ruta para el captcha
    path('captcha/', include('captcha.urls')),  
]
