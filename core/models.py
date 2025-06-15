from django.db import models
from django.contrib.auth.models import User
from django.db.models.signals import post_save
from django.dispatch import receiver


class Profile(models.Model):
    user = models.OneToOneField(User, on_delete=models.CASCADE, verbose_name="Usuario")
    bio = models.TextField(max_length=500, blank=True, verbose_name="Biografía")
    location = models.CharField(max_length=100, blank=True, verbose_name="Ubicación")
    birth_date = models.DateField(null=True, blank=True, verbose_name="Fecha de nacimiento")
    profile_picture = models.ImageField(upload_to='profile_pics/', blank=True, null=True, verbose_name="Foto de perfil")

    class Meta:
        verbose_name = "Perfil"
        verbose_name_plural = "Perfiles"

    def __str__(self):
        return f"Perfil de {self.user.username}"


class Message(models.Model):
    sender = models.ForeignKey(Profile, related_name='sent_messages', on_delete=models.CASCADE, verbose_name="Remitente")
    recipient = models.ForeignKey(Profile, related_name='received_messages', on_delete=models.CASCADE, verbose_name="Destinatario")
    content = models.TextField(verbose_name="Contenido")
    timestamp = models.DateTimeField(auto_now_add=True, verbose_name="Fecha y hora")
    is_read = models.BooleanField(default=False, verbose_name="Leído")

    class Meta:
        verbose_name = "Mensaje"
        verbose_name_plural = "Mensajes"
        ordering = ['-timestamp']

    def __str__(self):
        return f"Mensaje de {self.sender.user.username} a {self.recipient.user.username}"


class Friend(models.Model):
    owner = models.ForeignKey(Profile, related_name='friends', on_delete=models.CASCADE)
    friend = models.ForeignKey(Profile, related_name='friend_of', on_delete=models.CASCADE)
    created_at = models.DateTimeField(auto_now_add=True)

    class Meta:
        verbose_name = "Amigo"
        verbose_name_plural = "Amigos"
        unique_together = ('owner', 'friend')

    def __str__(self):
        return f"{self.owner.user.username} es amigo de {self.friend.user.username}"


class FriendRequest(models.Model):
    from_user = models.ForeignKey(User, related_name='sent_requests', on_delete=models.CASCADE)
    to_user = models.ForeignKey(User, related_name='received_requests', on_delete=models.CASCADE)
    timestamp = models.DateTimeField(auto_now_add=True)
    accepted = models.BooleanField(default=False)

    class Meta:
        verbose_name = "Solicitud de amistad"
        verbose_name_plural = "Solicitudes de amistad"

    def __str__(self):
        return f"Solicitud de {self.from_user.username} a {self.to_user.username}"


# Señal para crear o actualizar perfil automáticamente al crear o guardar un usuario
@receiver(post_save, sender=User)
def create_or_update_user_profile(sender, instance, created, **kwargs):
    if created:
        Profile.objects.create(user=instance)
    else:
        instance.profile.save()
